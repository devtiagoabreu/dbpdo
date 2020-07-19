<?php
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("05.04 - Consultas com query e exec");

require __DIR__ . "/../source/autoload.php";

use Source\Database\Connect;

/*
 * [ insert ] Cadastrar dados.
 * https://mariadb.com/kb/en/library/insert/
 *
 * [ PDO exec ] http://php.net/manual/pt_BR/pdo.exec.php
 * [ PDO query ]http://php.net/manual/pt_BR/pdo.query.php
 */
fullStackPHPClassSession("insert", __LINE__);

$inset = "
    INSERT INTO users (first_name, last_name, email, document)
    VALUES ('Robson', 'Leite', 'cursos@upinside.com.br', '23729473');
";

try {
    //$exec = Connect::getInstance()->exec($inset); // o comando exec retona 1 ou 0, ex. o comando DELETE que retorna 1 para deletado e 0 para não deletado
    //var_dump(Connect::getInstance()->lastInsertId());
    $exec = null;

    $query = Connect::getInstance()->query($inset); // o comando query retorna as informções necessárias como por exemplo um SELECT
    var_dump(Connect::getInstance()->lastInsertId());

    var_dump(
        $exec,
        $query->errorInfo()
    );


} catch (PDOException $exception) {
    var_dump($exception);
}


/*
 * [ select ] Ler/Consultar dados.
 * https://mariadb.com/kb/en/library/select/
 */
fullStackPHPClassSession("select", __LINE__);

try {
    $query = Connect::getInstance()->query("SELECT * FROM users LIMIT 2");
    var_dump([
        $query,
        $query->rowCount(), //quantidade de linhas da consulta
        $query->fetchAll()  //trazer todos os resultados
    ]);
} catch (PDOException $exception) {
    var_dump($exception);
}

/*
 * [ update ] Atualizar dados
 * https://mariadb.com/kb/en/library/update/
 */
fullStackPHPClassSession("update", __LINE__);

try {
    $exec = Connect::getInstance()->exec("
      UPDATE users SET first_name = 'Kaue', last_name = 'Cardoso'
      WHERE id > '50'
    ");

    var_dump($exec);

} catch (PDOException $exception) {
    var_dump($exception);
}

/*
 * [ delete ] Deletar dados.
 * https://mariadb.com/kb/en/library/delete/
 */
fullStackPHPClassSession("delete", __LINE__);

try {
    $exec = Connect::getInstance()->exec("DELETE FROM users WHERE id > 50");
    var_dump($exec);
} catch (PDOException $exception) {
    var_dump($exception);
}