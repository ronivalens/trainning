# Instruções

1. Realize o deploy da aplicação de calculadora de conversão de celcius para farenheit, utilizando a imagem ubi8/php-74.

2. Utilize os scripts Source-to-Image e criar uma imagem usando um Dockerfile, crie um Containerfile com um conteúdo como este, adaptando conforme sua necessidade:
   ```
   FROM ubi8/php-74
   # Add application sources to a directory that the assemble script expects them
   # and set permissions so that the container runs without root access
   USER 0
   ADD app-src /tmp/src
   RUN chown -R 1001:0 /tmp/src
   USER 1001

   # Install the dependencies
   RUN /usr/libexec/s2i/assemble

   # Set the default command for the resulting image
   CMD /usr/libexec/s2i/run
   ```

Use a documentação do [link](https://catalog.redhat.com/software/containers/ubi8/php-74/5f521244e05bbcd88f128b63?container-tabs=overview)

3. Construa um imagem de contêiner com o nome ```tjms/php```
Execute o contêiner com o nome ```php```, em segundo plano, na porta ```20081``` do host.
