1. Configurando pvc-registry
```
oc create -f pvc-openshift-image-registry.yaml
```

2. Substitua a declaração de volume persistente original na configuração do registro de imagem pela nova declaração:
```
oc patch configs.imageregistry.operator.openshift.io/cluster --type 'json' -p='[{"op": "replace", "path": "/spec/storage/pvc/claim", "value": "csi-pvc-imageregistry"}]'
```
