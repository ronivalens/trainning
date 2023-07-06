# Instruções

Antes de iniciar, certifique de ter instalado o docker desktop e kompose para o seu ambiente:

Instalação Docker Desktop: https://docs.docker.com/desktop/install/windows-install/
Instalação Kompose: https://kompose.io/installation/

# Prática

## Provisionamento via Docker Compose

1. Crie o arquivo ```docker-compose.yml```

```
# versão da api
version: '3.3'
```

2. Vamos inserir um campo para a persistencia de um volume chamado ```data```

```
volumes:
  data:
```
3. Insira o campo ```services``` para a criação dos workloads necessários:

```
services:
```

4. Agora vamos criar um serviço chamado ```db``` para provisionar um contêiner ```mysql```:

```
  db:
    image: mysql:latest
    ports:
      - "3306:3306"
    volumes:
      - data:/var/lib/mysql
    environment:
      - MYSQL_ROOT_PASSWORD=password
      - MYSQL_DATABASE=app_development
```

5. Neste momento vamos inserir o conteudo do serviço ```app```, para provisionar um contêiner ```phpmyadmin```:

```
  app:
    image: bitnami/phpmyadmin:latest
    links:
      - db
    ports:
      - 8080:8080
    environment:
      - PMA_ARBITRARY=1
      - PHPMYADMIN_ALLOW_REMOTE_CONNECTIONS=true
      - DATABASE_ENABLE_SSL=false
      - DATABASE_HOST=db
      - DATABASE_PORT_NUMBER=3306
```
Obs.: Variaveis para acessar diretamente o banco de dados ```db```.

6. Para provisionar localmente execute o comando abaixo:

```
docker compose up
```

7. Se tudo correu bem, você verá no seu terminal em execução o seguinte conteudo:

```
...
mysql-phpmyadmin-db-1   | 2023-07-06T14:24:52.708014Z 0 [System] [MY-010931] [Server] /usr/sbin/mysqld: ready for connections. Version: '8.0.33'  socket: '/var/run/mysqld/mysqld.sock'  port: 3306  MySQL Community Server - GPL.
```

8. Acesse em sua estação o endereço http://localhost:8080/

![](images/phpmyadmin_local.png?raw=true)

## Provisionamento dos Workloads no Openshift

1. Vamos utilizar o [Kompose](https://kompose.io/), que é uma ferramenta de conversão para arquivos ```docker-compose.yml``` para manifestos yaml, sendo assim possivel orquestra-los em plataforma kubernetes/openshift.

1.1. No diretório mysql-phpmyadmin execute o comando de conversão:

```
kompose convert -o ./openshift/
```

1.2. Se tudo correu bem, você verá os manifestos ```yaml``` gerados no diretório criado:

```
app-deployment.yaml
app-service.yaml
data-persistentvolumeclaim.yaml
db-deployment.yaml
db-service.yaml
mysql-phpmyadmin-default-networkpolicy.yaml
```

2. Com estes manifestos criados, vamos criar agora nosso projeto no openshift e criar os recursos:

```
oc new-project phpmyadmin

oc create -f openshift/.
```
2.1. Você verá a seguinte saida:
```
deployment.apps/app created
service/app created
persistentvolumeclaim/data created
deployment.apps/db created
service/db created
networkpolicy.networking.k8s.io/mysql-phpmyadmin-default created
```

3. Verifique a implantação e os recursos criados:

```
oc status
svc/app - 172.30.249.99:8080
  deployment/app deploys bitnami/phpmyadmin:latest
    deployment #1 running for about a minute - 1 pod

svc/db - 172.30.116.37:3306
  deployment/db deploys mysql:latest
    deployment #1 running for about a minute - 1 pod


2 infos identified, use 'oc status --suggest' to see details.
```

```
oc get all

NAME                       READY   STATUS    RESTARTS   AGE
pod/app-65bb747c7b-xk52x   1/1     Running   0          98s
pod/db-99cb88548-4hmf9     1/1     Running   0          98s

NAME          TYPE        CLUSTER-IP      EXTERNAL-IP   PORT(S)    AGE
service/app   ClusterIP   172.30.249.99   <none>        8080/TCP   98s
service/db    ClusterIP   172.30.116.37   <none>        3306/TCP   98s

NAME                  READY   UP-TO-DATE   AVAILABLE   AGE
deployment.apps/app   1/1     1            1           98s
deployment.apps/db    1/1     1            1           98s

NAME                             DESIRED   CURRENT   READY   AGE
replicaset.apps/app-65bb747c7b   1         1         1       98s
replicaset.apps/db-99cb88548     1         1         1       98s
```

4. Verifique a persistencia criada:

```
oc get pvc

NAME   STATUS   VOLUME                                     CAPACITY   ACCESS MODES   STORAGECLASS          AGE
data   Bound    pvc-445c6e23-b458-4e8f-b343-fa14190274a8   100Mi      RWO            managed-nfs-storage   2m57s 
```

5. Crie a rota para acessar o service ```app```:

```
oc expose svc app
```

6. Verifique a rota criada e acesse a pagina:
```
oc get route app --output jsonpath={.spec.host}
<SUA_URL>
```

7. Para finalizar, acesse a url e insira as senhas geradas nas variaveis de ambiente ```MYSQL_ROOT_PASSWORD=password```:

![](images/phpmyadmin_openshift.png?raw=true)
![](images/phpmyadmin_login.png?raw=true)
