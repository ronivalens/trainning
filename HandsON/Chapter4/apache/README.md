# HandsOn
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
