## Instruções

2. Autentique-se com o cluster OpenShift usando o comando `oc login`. Certifique-se de fornecer o URL correto do cluster e suas credenciais.

```
oc login <URL_do_cluster>
```

2. Crie um novo projeto ```ubi-echo```


```
oc new-project ubi-echo
```

3. Crie um novo aplicativo chamado "echo" do Containerfile na pasta ubi-echo. Ele cria, entre outros recursos, uma ```buildConfig```:

```
oc new-app --name echo https://github.com/netoralves/training --context-dir HandsON/Chapter4/ubi-echo 
```

4. Acompanhe os logs de build:

```
oc logs -f bc/echo
```

5. Verifique o status:

```
oc status
```

6. Aguarde o pod do aplicativo estar pronto e ser executado. Repita o comando oc get pod até que a saída seja semelhante à seguinte:




Passo 6: Agora você está pronto para usar o comando `oc new-app`. Existem várias opções disponíveis, dependendo da origem do seu aplicativo. Aqui estão alguns exemplos:

- Criar um aplicativo a partir de um repositório Git:

```
oc new-app <URL_do_repositório_Git>
```

- Criar um aplicativo a partir de uma imagem de contêiner:

```
oc new-app <nome_da_imagem_do_contêiner>
```

- Criar um aplicativo a partir de um modelo pré-definido:

```
oc new-app --template=<nome_do_modelo>
```

Passo 7: Após executar o comando `oc new-app`, o OpenShift 4.13 iniciará o processo de criação e implantação do aplicativo. Você pode acompanhar o progresso usando o comando `oc logs` seguido do nome do pod do aplicativo.

```
oc logs <nome_do_pod>
```

Passo 8: Uma vez que o aplicativo esteja em execução, você pode expô-lo externamente usando o comando `oc expose`.

```
oc expose svc/<nome_do_serviço>
```

Passo 9: Agora você pode acessar seu aplicativo implantado usando o endereço fornecido pela rota exposta.

Parabéns! Você concluiu com sucesso o tutorial de uso do comando `oc new-app` no OpenShift 4.13. Agora você pode implantar facilmente seus aplicativos no ambiente OpenShift, seja a partir de um repositório Git, uma imagem de contêiner ou um modelo pré-definido.
