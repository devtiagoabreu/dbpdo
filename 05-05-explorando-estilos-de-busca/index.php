<?php
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("05.05 - Explorando estilos de busca");

require __DIR__ . "/../source/autoload.php";

use Source\Database\Connect;

/*
 * [ fetch ] http://php.net/manual/pt_BR/pdostatement.fetch.php
 */
fullStackPHPClassSession("fetch", __LINE__);

$connect = Connect::getInstance();
$read = $connect->query("SELECT * FROM users LIMIT 3");

if (!$read->rowCount()) { //se não retornar resultados
    echo "<p class='trigger warning'>Não obteve resultados.</p>";
} else {
    //var_dump($read->fetch()); // mostra o primeiro resultado

    while ($user = $read->fetch()) { //para acessar os demais deve ser usado dentro do laço while
        var_dump($user);
    }

    var_dump($read->fetch()); //ele retorna false pois já está liberado sem resultados, todos foram percorridos no laço
}


/*
 * [ fetch all ] http://php.net/manual/pt_BR/pdostatement.fetchall.php
 */
fullStackPHPClassSession("fetch all", __LINE__); //o fetch all retorna um array com todos os resultados

$read = $connect->query("SELECT * FROM users LIMIT 3,2");

//while ($user = $read->fetchAll()) {
//    var_dump($user);
//}

foreach ($read->fetchAll() as $user) { // para percorrer este array utilizamos o laço foreach
    var_dump($user);
}

var_dump($read->fetchAll());


/*
 * [ fetch save ] Realziar um fetch diretamente em um PDOStatement resulta em um clear no buffer da consulta. Você
 * pode armazenar esse resultado em uma variável para manipilar e exibir posteriormente.
 */
fullStackPHPClassSession("fetch save", __LINE__); // quando os dados precisam ser mantidos basta salvá-los em uma variável ex: result

$read = $connect->query("SELECT * FROM users LIMIT 5,1");
$result = $read->fetchAll();

var_dump(
    $read->fetchAll(),
    $result,
    $result
);

/*
 * [ fetch styles ] Estilos de busca
 */
fullStackPHPClassSession("fetch styles", __LINE__);

$read = $connect->query("SELECT * FROM users LIMIT 1");
foreach ($read->fetchAll() as $user) {
    var_dump($user, $user->first_name);
}

$read = $connect->query("SELECT * FROM users LIMIT 1");
foreach ($read->fetchAll(PDO::FETCH_NUM) as $user) {
    var_dump($user, $user[1]);
}

$read = $connect->query("SELECT * FROM users LIMIT 1");
foreach ($read->fetchAll(PDO::FETCH_ASSOC) as $user) {
    var_dump($user, $user['first_name']);
}

$read = $connect->query("SELECT * FROM users LIMIT 1");
foreach ($read->fetchAll(PDO::FETCH_CLASS, \Source\Database\Entity\UserEntity::class) as $user) {
    /** @var \Source\Database\Entity\UserEntity $user */
    var_dump($user, $user->getFirstName());
}
