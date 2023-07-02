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

# Deploy da App

1. Com a visão de ```Developer``` no webconsole, acesse a aba ```+Add```

2. Na tela inicial, certifique que esta no projeto ```cadastro-pessoas``` e clique em ```All services```

3. No campo de pesquisa, procure por php, e use o item ```PHP (Builder Images)```, em seguida clique em ```Create```

4. No formulário de criação, altere os seguintes campos conforme abaixo(mantenha os demais):
```
Builder Image version: 74-ubi8
Git Repo URL: https://github.com/netoralves/trainning.git
Show Advanced Git Options
  Context dir: /HandsON/Chapter4/cadastro_de_pessoas/src
  Application: Create application
  Application name: cadastro-pessoas
  Name: cadastro-pessoas
```
Clique em ```Create```

5. Na tela ```Topology```, clique em Builds > Build #1 > View logs e verifique nos logs se o processo de build foi executado com sucesso;

6. Volte a tela ```Topology```, no Deployment ```cadastro-pessoas```, verifique se o Pod cadastro pessoas está com status "Running".

7. Se todas as validações acima estão OK, role na aba ao lado com o item DC cadastro-pessoas selecionado, e clique em Routes > Locations: > Link para acesso a app, voce será redirecionado para a tela da sua aplicação implantada.

![](images/cadastro-pessoas.png?raw=true)
