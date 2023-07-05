# Instruções

1. No terminal com o cli ```oc``` conectado com seu usuario, crie o projeto ```php-helloworld```:

```
oc new-project php-helloworld
```

2. Depois, logado neste projeto, crie a build para o projeto:

```
oc new-build --strategy=source --name=php-helloworld -l app=php-helloworld --context-dir='HandsON/Chapter4/php/src' https://github.com/netoralves/trainning.git
```

4. Você verá o seguinte retorno:

``` 
--> Found image 84baac2 (12 days old) in image stream "openshift/php" under tag "8.0-ubi8" for "php"

    Apache 2.4 with PHP 8.0
    -----------------------
    PHP 8.0 available as container is a base platform for building and running various PHP 8.0 applications and frameworks. PHP is an HTML-embedded scripting language. PHP attempts to make it easy for developers to write dynamically generated web pages. PHP also offers built-in database integration for several commercial and non-commercial database management systems, so writing a database-enabled webpage with PHP is fairly simple. The most common use of PHP coding is probably as a replacement for CGI scripts.

    Tags: builder, php, php80, php-80

    * The source repository appears to match: php
    * A source build using source code from https://github.com/netoralves/trainning.git will be created
      * The resulting image will be pushed to image stream tag "php-helloworld:latest"
      * Use 'oc start-build' to trigger a new build

--> Creating resources with label app=php-helloworld ...
    imagestream.image.openshift.io "php-helloworld" created
    buildconfig.build.openshift.io "php-helloworld" created
--> Success
```

5. Agora verifique todos os recursos criados no projeto:
```
oc get all                                                                                                                                                                                  ✔  1507  09:36:48
NAME                         READY   STATUS      RESTARTS   AGE
pod/php-helloworld-1-build   0/1     Completed   0          3m56s

NAME                                            TYPE     FROM   LATEST
buildconfig.build.openshift.io/php-helloworld   Source   Git    1

NAME                                        TYPE     FROM          STATUS     STARTED         DURATION
build.build.openshift.io/php-helloworld-1   Source   Git@f4fd1cd   Complete   3 minutes ago   46s

NAME                                            IMAGE REPOSITORY                                                                 TAGS     UPDATED
imagestream.image.openshift.io/php-helloworld   image-registry.openshift-image-registry.svc:5000/php-helloworld/php-helloworld   latest   3 minutes ago
```

Com isso a build da sua imagem já está pronta para ser utilizada.

6. Vamos agora usar esta imagem gerada da build para implantar sua aplicação:

6.2. Verifique os novos recursos criados, e repare nos recursos ```deployment```, ```replicaset``` e ```service```, além do novo ```pod``` da aplicação, gerado pelo deployment e ```replicaset```:

```
oc get all                                                                                                                                                                        SIGINT(2) ↵  1512  09:42:14
NAME                                  READY   STATUS      RESTARTS   AGE
pod/php-helloworld-1-build            0/1     Completed   0          9m51s
pod/php-helloworld-77cc8cb788-m4dwk   1/1     Running     0          62s

NAME                     TYPE        CLUSTER-IP       EXTERNAL-IP   PORT(S)             AGE
service/php-helloworld   ClusterIP   172.30.221.193   <none>        8080/TCP,8443/TCP   62s

NAME                             READY   UP-TO-DATE   AVAILABLE   AGE
deployment.apps/php-helloworld   1/1     1            1           62s

NAME                                        DESIRED   CURRENT   READY   AGE
replicaset.apps/php-helloworld-6bd96c7d56   0         0         0       62s
replicaset.apps/php-helloworld-77cc8cb788   1         1         1       62s

NAME                                            TYPE     FROM   LATEST
buildconfig.build.openshift.io/php-helloworld   Source   Git    1

NAME                                        TYPE     FROM          STATUS     STARTED         DURATION
build.build.openshift.io/php-helloworld-1   Source   Git@f4fd1cd   Complete   9 minutes ago   46s

NAME                                            IMAGE REPOSITORY                                                                 TAGS     UPDATED
imagestream.image.openshift.io/php-helloworld   image-registry.openshift-image-registry.svc:5000/php-helloworld/php-helloworld   latest   9 minutes ago
```
6.3. Agora verifique a ```image``` usada no recurso ```deployment``` e a usada no recurso ```imageStream```:
```
oc describe deploy php-helloworld
oc describe is php-helloworld
```
Obs. Reparem que é a mesma imagem de referência:
```
# Deployment:
Image:        image-registry.openshift-image-registry.svc:5000/php-helloworld/php-helloworld@sha256:3cc23253532af43331bbdcb5976d9b1fd4576c8139452cc8b3a0f63b1b030e16

# ImageStream:
  * image-registry.openshift-image-registry.svc:5000/php-helloworld/php-helloworld@sha256:3cc23253532af43331bbdcb5976d9b1fd4576c8139452cc8b3a0f63b1b030e16
```
7. Agora exponha a rota e acesse a aplicação:

```
oc expose svc php-helloworld

oc get route php-helloworld --output jsonpath={.spec.host}
<SUA_URL>
```

8. Copie sua URL no navegador e execute a conversão de teste, você terá um resultado parecido com este:

![](images/calculate.png?raw=true)
