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
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD -h $HOSTNAME $MYSQL_DATABASE


mysql> USE cadastrodb;

mysql> CREATE TABLE pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);
Query OK, 0 rows affected (0.02 sec)
```


9. Verifique a tabela criada:
```
mysql> DESCRIBE pessoas;
+----------+--------------+------+-----+---------+----------------+
| Field    | Type         | Null | Key | Default | Extra          |
+----------+--------------+------+-----+---------+----------------+
| id       | int          | NO   | PRI | NULL    | auto_increment |
| nome     | varchar(100) | NO   |     | NULL    |                |
| email    | varchar(100) | NO   |     | NULL    |                |
| telefone | varchar(20)  | NO   |     | NULL    |                |
+----------+--------------+------+-----+---------+----------------+
4 rows in set (0.00 sec)
```

Ref.: https://docs.openshift.com/online/pro/using_images/db_images/mysql.html

