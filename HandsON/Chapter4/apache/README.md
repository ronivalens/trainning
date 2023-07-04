# Antes de iniciar:
## 1. Fork de repositórios GitHub

1.1 Para fazer fork de um repositório no GitHub, navegue até o repositório e clique em Fork no canto superior direito. Certifique-se de clicar em Fork e não no número ao lado do botão.

1.2 Selecione seu nome de usuário como destino e aguarde o processo ser finalizado.

1.3. Ao clonar o repositório para sua estação de trabalho, use a URL para seu fork que pode ser
encontrada clicando em Code. 

## Criação de um token de acesso pessoal do GitHub

Se você ainda não tem um token de acesso pessoal, use o guia Criação de token de acesso pessoal [https://docs.github.com/en/github/authenticating-to-github/keeping-your-account- and-data-secure/creating-a-personal-access-token] para criar um.

# Instruções
Revise o contudo do arquivo Containerfile fornecido na pasta neste diretório.

Edite o Containerfile e garanta que ele cumpra as seguintes especificações:

• A imagem de base é ```ubi8/ubi:8.5```

• Define o nome de autor e a ID de e-mail desejados com a instrução ```MAINTAINER```.

• Define a variável de ambiente ```PORT``` como ```8080```

• Instale o Apache (pacote httpd).

• Altere o arquivo de configuração /etc/httpd/conf/httpd.conf para ouvir na porta 8080 ao invés da porta padrão 80

• Altere a propriedade das pastas /etc/httpd/logs e /run/httpd para usuário e grupo apache (UID e GID são 48).

• Para que os usuários de contêiner saibam como acessar o servidor web Apache, exponha o valor definido na variável de ambiente PORT.

• Copie o conteúdo da pasta src/ no diretório do laboratório para o arquivo DocumentRoot do Apache (/var/www/html/) no contêiner.

• A pasta src contém um único arquivo index.html que imprime uma mensagem Hello, World!.

• Inicie o daemon httpd do Apache em primeiro plano usando a instrução CMD e o seguinte comando:
```
httpd -D FOREGROUND
```

## Prática
1. Construa um imagem de contêiner com o nome ```tjms/apache```, desabilite o armazenamento de imagens intermediárias em cache durante o processo de construção (o padrão é true).
Dica.: Consulte [documentação do Podman](https://docs.podman.io/en/latest/markdown/podman-build.1.html)

R.
```
cd trainning/HandsON/Chapter4/apache
podman build --layers=false -t tjms/apache .
```

3. Execute o contêiner com o nome ```containerfile```, em segundo plano, na porta 20080 do host.
Dica: Consulte [documentação do Podman](https://docs.podman.io/en/latest/markdown/podman-run.1.html)

R.
```
podman run -d --name php -p 20080:8080 tjms/apache
```
## Critério de Sucesso:
Para validar seu laboratório, execute o comando abaixo, o retorno deverá ser o conforme conteudo abaixo:
```
curl localhost:20080
<html>
  <body>
    <h1>Hello, World!</h1>
  </body>
</html>
```
