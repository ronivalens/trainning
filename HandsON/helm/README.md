# Instruções

1. Faça a instalação do binário da ferramenta helm baixando deste link
https://github.com/helm/helm/releases

2. Depois de baixar e publicar no PATH da sua estação de trabalho, teste o uso:
```
helm version

version.BuildInfo{Version:"v3.12.1", GitCommit:"f32a527a060157990e2aa86bf45010dfb3cc8b8d", GitTreeState:"clean", GoVersion:"go1.20.5"}
```

# Prática

1. Crie um novo helm chart:

1.1. Crie um helm chart chamado famouschart:
```
helm create famouschart
```

1.2. Verifique a estrutura de arquivos
```
cd famouschart
ls
Chart.yaml  charts      templates   values.yaml

tree .
.
├── Chart.yaml
├── charts
├── templates
│   ├── NOTES.txt
│   ├── _helpers.tpl
│   ├── deployment.yaml
│   ├── hpa.yaml
│   ├── ingress.yaml
│   ├── service.yaml
│   ├── serviceaccount.yaml
│   └── tests
│       └── test-connection.yaml
└── values.yam
```
obs.: Se não estiver utilizando um terminal linux ou não tiver a ferramenta ```tree``` instalada o comando ```ls``` ou ```dir``` ja consegue obter a verificação da criação da estrutura.

2. Configure a implantação de aplicativos

Use o arquivo values.yaml para configurar a implantação para o aplicativo.

2.1. Configure valores de imagem e versão.

Atualize o arquivo values.yaml, configurando a propriedade ```repository``` da seção ```image``` para a imagem ```quay.io/redhattraining/famous-quotes```, e defina a propriedade ```tag``` da mesma seção para o valor ```2.1``` para selecionar a versão apropriada do aplicativo.

A seção correspondente do arquivo values.yaml deve ter esta aparência:
```
image:
  repository: quay.io/redhattraining/famous-quotes
  pullPolicy: IfNotPresent
  tag: “2.1”

2.2. Certifique-se de que o contêiner use a porta correta para se conectar ao aplicativo.
No arquivo ```templates/deployment.yaml```, altere a propriedade ```containerPort``` incluída na seção ```containers``` para que ela use o valor 8000.

A seção correspondente do arquivo templates/deployment.yaml deve ter esta
aparência:

```
ports:
  - name: http
    containerPort: 8000
    protocol: TCP
```

3. Adicione a dependência do banco de dados.
O aplicativo Famous Quotes usa um banco de dados para armazenar as citações; por isso, você deve fornecer um banco de dados junto com o aplicativo para que funcione. Para isso, você deve fornecer a dependência para o gráfico do aplicativo e configurar o gráfico do banco de dados.

3.1. Adicione a dependência mariadb ao gráfico do aplicativo.
Para fazer isso, adicione o seguinte trecho ao final do arquivo Chart.yaml:
```
dependencies:
- name: mariadb
  version: 12.2.7
  repository: https://charts.bitnami.com/bitnami
```

3.2. Atualize as dependências do gráfico.
Isso faz o download dos gráficos adicionados como dependências e bloqueia suas versões.

```
helm dependency update

Getting updates for unmanaged Helm repositories...
...Successfully got an update from the "https://charts.bitnami.com/bitnami" chart repository
Saving 1 charts
Downloading mariadb from repo https://charts.bitnami.com/bitnami
Deleting outdated charts
```

3.3. Configure o banco de dados para usar valores personalizados para autenticação e segurança.
Para transmitir os mesmos valores para o aplicativo implantado, você deve controlar seus valores em vez de deixar o gráfico do Helm do banco de dados criá-los aleatoriamente.
Adicione as seguintes linhas ao final do arquivo ```values.yaml```:

```
mariadb:
  auth:
    rootPassword: rootPassword
    username: quotes
    password: quotespwd
    database: quotesdb
  primary:
    podSecurityContext:
      enabled: false
    containerSecurityContext:
      enabled: false
```

4. Configure o acesso ao banco de dados do aplicativo usando variáveis de ambiente.

4.1. O template de implantação padrão não passa nenhuma variável de ambiente para os aplicativos implantados. Modifique o template templates/deployment.yaml para passar as variáveis de ambiente definidas no arquivo values.yaml para o contêiner do aplicativo e adicione o seguinte trecho após o valor imagePullPolicy na seção containers:

```
imagePullPolicy: {{ .Values.image.pullPolicy }}
env:
  {{- range .Values.env }}
- name: {{ .name }}
  value: {{ .value }}
  {{- end }}
```

4.2. Adicione as variáveis de ambiente apropriadas ao final do arquivo ```values.yaml```:
```
env:
  - name: "QUOTES_HOSTNAME"
    value: "famousapp-mariadb"
  - name: "QUOTES_DATABASE"
    value: "quotesdb"
  - name: "QUOTES_USER"
    value: "quotes"
  - name: "QUOTES_PASSWORD"
    value: "quotespwd"
```

5. Implante o aplicativo usando o gráfico do Helm.

5.1. Faça a instalação do helm no openshift

```
helm install famousapp .
```

Esse comando cria uma implantação do RHOCP chamada famousapp.

5.1. Para verificar o status dessa implantação, use o comando oc get deployments:

```
oc get deployments
```

Use o comando oc get pods várias vezes para verificar se o aplicativo e o banco de dados foram implantados corretamente:

```
oc get pods
```

6. Teste o aplicativo

6.1. Exponha o serviço do aplicativo:
```
oc expose service famousapp-famouschart
```

6.2. Chame o endpoint /random do aplicativo implantado:
```
FAMOUS_URL=$(oc get route -n ${RHT_OCP4_DEV_USER}-multicontainer-helm famousapp-famouschart -o jsonpath='{.spec.host}'/random)

curl $FAMOUS_URL
8: Those who can imagine anything, can create the impossible.
- Alan Turing

curl $FAMOUS_URL
1: When words fail, music speaks.
- William Shakespeare
```

