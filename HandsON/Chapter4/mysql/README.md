# Instruções
1. Acesse via SSH o SNO
```
ssh core@<ipAddress>
```

2.  Faça login no cluster Openshift
oc login -u kubeadmin -p <senha> api.<ClusterName>.<Domain>

3. Crie um projeto chamado mysql-openshift
oc new-project mysql-openshift

4. Crie um novo aplicativo a partir do template mysql-persistent usando o comando oc new-app, com os seguintes parametros:
```
MYSQL_USER=user1
MYSQL_PASSWORD=mypa55
MYSQL_DATABASE=testdb
MYSQL_ROOT_PASSWORD=r00tpa55
VOLUME_CAPACITY=10Gi
```

Use a opção --template com o comando oc new-app para especificar um template com armazenamento persistente para que o OpenShift não faça pull da imagem da Internet:

```
oc new-app --template=mysql-persistent -p MYSQL_USER=user1 -p MYSQL_PASSWORD=mypa55 -p MYSQL_DATABASE=testdb -p MYSQL_ROOT_PASSWORD=r00tpa55 -p VOLUME_CAPACITY=10Gi
```

5. Verifique se o pod do MySQL foi criado com êxito e visualize os detalhes sobre o pod e seu serviço.
```
oc status
oc get pods
```
Obs.: Observe o nome do pod em execução. Você precisará dessa informação para fazer login no servidor de banco de dados MySQL posteriormente.

6. Use o comando oc describe para visualizar mais detalhes sobre o pod:
```
oc describe pod <pod_name>
```

Obs.: A saída do comando oc describe pode conter erros relacionados à investigação readiness. Você pode ignorar esses erros.



7. Liste os serviços neste projeto e verifique se o serviço de acesso ao MySQL foi criado:
```
oc get svc
```

8. Recupere os detalhes do serviço mysql usando o comando oc describe e observe se o tipo de serviço é ClusterIP por padrão:
```
oc describe service mysql
```

9. Liste as afirmações de armazenamento persistente neste projeto:
oc get pvc

10. Recupere os detalhes da PVC mysql usando o comando oc describe
```
oc describe pvc/mysql
```
