# Instruções

1. Realize o deploy da aplicação de calculadora de conversão de celcius para farenheit, utilizando a imagem ubi8/php-74.

Dica: Para usar os scripts Source-to-Image e criar uma imagem usando um Containerfile, crie seu Containerfile com base na documentação na [documentação](https://catalog.redhat.com/software/containers/ubi8/php-74/5f521244e05bbcd88f128b63?container-tabs=overview) ou execute o comando
```
podman build --help
```

2. Construa um imagem de contêiner com o nome ```tjms/php```
Execute o contêiner com o nome ```php```, em segundo plano, na porta ```20081``` do host.

Dica: Consulte [documentação do Podman](https://docs.podman.io/en/latest/markdown/podman-run.1.html) ou execute o comando
```
podman run --help
```

## Critério de Sucesso:
Para validar seu laboratório, acesse da sua maquina o endereço: http://<ip_do_host>:20081, voce vera uma tela conforme imagem abaixo:

(images/calculate.png?raw=true)
