# Sobre
Aplicação Simples Spring Boot "Hello-World".

# Instruções

1. Crie um projeto no Openshift chamado ```springboot```:
```
oc new-project springboot
```

2. Faça o import da imagem a ser utilizada:

2.1. Para arquitetura x86_64:
```
oc import-image redhat-openjdk-18/openjdk18-openshift:1.15-6.1687264188 --from=registry.redhat.io/redhat-openjdk-18/openjdk18-openshift:1.15-6.1687264188 --confirm
```
Obs.: [Link de referencia](https://catalog.redhat.com/software/containers/redhat-openjdk-18/openjdk18-openshift/58ada5701fbe981673cd6b10?container-tabs=gti)

2.2. Para arquitetura ARM64:
```
oc import-image ubi8/openjdk-8:1.16-1.1687182685 --from=registry.access.redhat.com/ubi8/openjdk-8:1.16-1.1687182685 --confirm
```

3. Faça a implantação da app:

3.1. Para arquitetura x86_64:
```
oc new-app --strategy=source --name springboot --context-dir HandsON/Chapter4/springboot  springboot/openjdk18-openshift:1.15-6.1687264188~https://github.com/netoralves/trainning.git
```

3.2. Para arquitetura ARM64:
```
oc new-app --strategy=source --name springboot --context-dir HandsON/Chapter4/springboot springboot/openjdk-8:1.16-1.1687182685~https://github.com/netoralves/trainning.git
arm64v8/openjdk
```

4. Verifique a implantação:
```
oc status
oc get pods
```
5. Faça a exposição do serviço e acesse a app:

5.1. Criando a rota de acesso externo ao cluster:

```
oc expose svc
```

5.2. Acesse a webconsole: Networking > Route > Selecione o projeto ```springboot``` e clique no link ```Location``` da rota ```springboot```.

6. Atualize o código no seu repositório 
