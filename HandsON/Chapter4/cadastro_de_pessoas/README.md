# Deploy Cadastro de Pessoas

1. Acesso o Console de gerenciamento

2. Na aba ```Home``` > ```Projects``` > ```Create Project```, informe os dados abaixo e clique em ```Create```:
```
Name: cadastro-pessoas
Display Name: Sistema de Cadastro de Pessoas
```

3. Altera a percepção de usuario para ```Developer``` e clique em ```+Add```

4. Na tela inicial clique na opção ```Database``` do ```Developer Catalog```

5. Clique no template ```MySQL```, em seguida clique em ```Instantiate Template```

6. Informe ou altere os seguintes campos no formulario(não altere os demais campos), e clique em ```Create`:

```
MySQL Connection Username: cadastro
MySQL Connection Password: UxrsHuI1LdBsuDnM
MySQL root user Password: gDdiBOCSGQIDvs5r
MySQL Database Name: cadastrodb
```
7. Clique no Grafico ```DC mysql```, na aba ```Resources```, clique no Pod em execução.

8. Na pagina do Pod, acesse a aba ```Terminal```, e execute os seguintes comandos:

```
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD -h $HOSTNAME $MYSQL_DATABASE --socket=/var/lib/mysql/mysqlx.sock

mysql> USE cadastrodb;

mysql> CREATE TABLE pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

```

9. Verifique a tabela criada:
```

