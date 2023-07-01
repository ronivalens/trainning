<h1 align="center"> 1. Instalando um cluster Single Node Openshift (SNO) </h1>

1.1. No host de administração, abra um navegador e navegue até o [Red Hat OpenShift Cluster Manager](https://console.redhat.com/openshift/assisted-installer/clusters).

1.2. Clique em "Create Cluster" para criar um novo cluster.

1.3. No campo Nome do cluster, insira um nome para o cluster.

1.4. No campo Domínio base, insira um domínio base. Por exemplo:
'''
example.com
'''
1.5. No campo "CPU Architecture" defina para a arquitetura do processador a ser utilizado no ambiente virtualizado. Por exemplo:
'''
x86_64
'''

1.6. Marque o checkbox da opção Install single node Openshift (SNO)

1.7. Mantenha as demais opções e clique en Next

1.8. Na etapa Operators, mantenha os 2 checkboxs das opções existentes desmarcados e clique en Next

1.9. Na etapa Host discovery, mantenha o "Provisioning Type" como "Minimal image file - Provision with virtual media"

1.10. Na caixa SSH public key, informe sua chave publica SSH, depois clique em "Generate Discovery ISO". Por exemplo:
'''
cat ~/.ssh/id_rsa.pub
'''

1.11. Quando concluir a geração da ISO, clique em "Download Discovery ISO" e aguardo o download ser concluido.

1.12. No hypervisor utilizado, faça o upload da imagem, e a utilize para o boot da sua VM

Obs.: a VM deve possuir as seguintes configurações minimas:

| RECURSOS  | QUANTIDADE |
| --------- | ---------- |
|    CPU    |  10 Cores  |
|  Memória  |   16 GB    |
|   Disco   |   120 GB   | 


1.13. Acompanhe o boot da VM e monitore as mudanças de status e identificação do inventario de host da sua nova VM, aguarde até a conclusão da instalação.

Obs. Tempo médio para a conclusão: 20 min.

<h1 align="center"> 2. Checklist para a saude de um cluster OpenShift 4 </h1>

Exercite e valide os comandos apresentados abaixo para garantir que todos os componentes estejam funcionando corretamente. Aqui está um checklist prático com passos que você pode seguir para validar a saúde do seu cluster:

2.1. Verifique o status do cluster:
   - Use o comando `oc get nodes` para verificar se todos os nós estão em condição "Ready".
   - Execute `oc get pods --all-namespaces` para garantir que todos os pods estejam em estado "Running" ou "Completed".

2.2. Monitore a utilização de recursos:
   - Utilize ferramentas de monitoramento, como Prometheus, Grafana ou o console de monitoramento integrado do OpenShift, para verificar a utilização de CPU, memória e armazenamento nos nós do cluster.
   - Observe se há gargalos de recursos e tome as medidas adequadas, como escalar horizontalmente os nós de trabalho.

2.3. Verifique a integridade do cluster:
   - Execute `oc get clusteroperators` para verificar o estado dos diferentes operadores do cluster, como etcd, ingress, network, authentication, entre outros. Verifique se todos estão em estado "Available" ou "Degraded".
   - Utilize `oc get events --all-namespaces` para verificar se há eventos ou erros relatados no cluster.

2.4. Teste a conectividade da rede:
   - Execute `oc get svc` para listar os serviços disponíveis no cluster e verifique se estão com os IPs corretos.
   - Verifique se a comunicação entre os nós do cluster está funcionando corretamente executando `oc debug node/<node-name>` e realizando testes de ping e acesso a serviços internos.

2.5. Valide a autenticação e autorização:
   - Verifique se os usuários e grupos estão corretamente autenticados e têm as permissões apropriadas definidas.
   - Execute `oc whoami` para verificar se você está autenticado corretamente e possui as permissões adequadas.

2.6. Teste a implantação de aplicativos:
   - Implante um aplicativo de teste utilizando `oc new-app` e verifique se ele é criado corretamente e está em execução.
   - Acesse o aplicativo implantado e verifique se ele está respondendo corretamente.

2.7. Verifique a capacidade de escala do cluster:
   - Realize um teste de escala horizontal adicionando novos nós de trabalho ao cluster e verifique se eles são integrados corretamente e estão funcionando.
   - Monitore o balanceamento de carga e a distribuição de carga entre os nós de trabalho.

2.8. Execute testes de resiliência:
   - Simule falhas de nós ou pods e observe como o cluster se recupera e mantém a disponibilidade dos aplicativos.
   - Realize testes de failover para verificar a resiliência do cluster.

Lembre-se de que esse checklist é apenas uma diretriz geral e os passos podem variar dependendo da configuração específica do seu cluster.
É sempre importante consultar a documentação oficial do OpenShift e seguir as melhores práticas recomendadas pela Red Hat para validar a saúde do seu cluster.

![Badge em Desenvolvimento](http://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=GREEN&style=for-the-badge)
