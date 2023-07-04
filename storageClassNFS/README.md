# NFS Server
```
dnf install -y vim-enhanced nfs-utils
mkdir /var/nfsshare
chmod 777 /var/nfsshare
chown -R 65534:65534 /var/nfsshare
echo 'Y' > /sys/module/nfsd/parameters/nfs4_disable_idmapping
```

```
cat > /etc/exports << EOF
/var/nfsshare     *(rw,sync,no_wdelay,no_root_squash,insecure,fsid=0)
EOF
```

```
systemctl enable --now rpcbind nfs-server
```

```
export FIREWALLD_DEFAULT_ZONE=`firewall-cmd --get-default-zone`
echo ${FIREWALLD_DEFAULT_ZONE}
firewall-cmd --permanent --zone=${FIREWALLD_DEFAULT_ZONE} --add-service=rpc-bind
firewall-cmd --permanent --zone=${FIREWALLD_DEFAULT_ZONE} --add-service=nfs
firewall-cmd --permanent --zone=${FIREWALLD_DEFAULT_ZONE} --add-service=mountd
firewall-cmd --reload
firewall-cmd --list-all
```

```
setsebool -P nfs_export_all_rw 1
setsebool -P nfs_export_all_ro 1
setsebool -P virt_use_nfs 1
semanage fcontext -a -t public_content_rw_t  "/var/nfsshare(/.*)?"
restorecon -R /var/nfsshare
```

# NFS Client

## Testing
```
mkdir /mnt/nfs4
mount -t nfs nfs-server:/var/nfsshare /mnt/nfsv4
touch /mnt/1 && rm -f /mnt/1
```

## Deploy nfs-provisioner
```
oc new-project nfs-storage
oc label namespace nfs-storage "openshift.io/cluster-monitoring=true"
NAMESPACE=`oc project -q`
sed -i'' "s/namespace:.*/namespace: $NAMESPACE/g" ./deploy/rbac.yaml

# x86_64 Architecture
sed -i'' "s/namespace:.*/namespace: $NAMESPACE/g" ./deploy/deployment.yaml

# ARM64 Architecture
sed -i'' "s/namespace:.*/namespace: $NAMESPACE/g" ./deploy/deployment-arm64.yaml

# Create Roles and ClusterRoles:
oc create -f deploy/rbac.yaml
oc adm policy add-scc-to-user hostmount-anyuid system:serviceaccount:$NAMESPACE:nfs-client-provisioner

# Deply StorageClass
oc create -f deploy/class.yaml


# ARM64 Architecture
oc create -f deploy/deployment-arm64.yaml

# x86_64 Architecture
oc create -f deploy/deployment.yaml

# Set Default StorageClass
oc patch storageclass managed-nfs-storage -p '{"metadata": {"annotations": {"storageclass.kubernetes.io/is-default-class": "true"}}}'
```

