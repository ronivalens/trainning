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

```
[core@00-1c-42-33-b1-09 ubi-echo]$ oc get pods
NAME                    READY   STATUS      RESTARTS   AGE
echo-1-build            0/1     Completed   0          43s
echo-764d7dfccb-8n2k4   1/1     Running     0          30s
```

7. Exiba os logs de pod do aplicativo para mostrar que a imagem de contêiner do aplicativo está produzindo a saída esperada no OpenShift. Use o nome do pod do aplicativo que obteve na etapa anterior:

```
[core@00-1c-42-33-b1-09 ubi-echo]$ oc logs echo-764d7dfccb-8n2k4 | tail -n 3
test
test
test
```

8. Inspecione a configuração da build:

```
oc describe bc echo
```

9. Revise o imageStream:

```
oc describe bc echo
```

10. Revise o Deployment:

```
oc describe deployment echo
```

## Alteração do aplicativo:

Obs.: Se voce não realizou o fork do repositório para sua conta, acompanhe comigo os passos executados abaixo:

1. Altere o aplicativo:

```
FROM registry.access.redhat.com/ubi8/ubi:8.0
USER 1001
CMD bash -c "while true; do (( i++ )); echo test \$i; sleep 5; done"
```

2. Confirme e envie por push as alterações para o Git:

```
git commit -a -m 'Add a counter'
git push
```

13. Inicialize uma nova build:

```
oc start-build echo
```

14. Acompanhe os novos logs da build:

```
oc logs -f bc/echo
```

15. Compare o status do imageStream antes e depois de recompilar o aplicativo. Inspecione o status atual do fluxo de imagem:
```
oc describe is echo
...
 * image-registry.openshift-image-registry.svc:5000/youruser-docker-build/
echo@sha256:025a...542f
      2 minutes ago
    image-registry.openshift-image-registry.svc:5000/youruser-docker-build/
echo@sha256:5bbf...ef0b
```
Obs.: A url da imagem que é apresentada em primeiro, é a nova imagem gerada, a segunda apresentada é a mais antiga.
