<?php


require '../vendor/autoload.php';

// use namespace
use Aura\SqlQuery\QueryFactory;

$queryFactory = new QueryFactory('mysql'); //init
$select = $queryFactory->newSelect();

$select->cols(['*'])
    ->from('posts');

    // var_dump($select->getStatement());die;
    // a PDO connection
$pdo = new PDO("mysql:host=mysql; dbname=laravel; charset=utf8;", "user", "secret");

// prepare the statement
$sth = $pdo->prepare($select->getStatement());

// bind the values and execute
$sth->execute($select->getBindValues());

// get the results back as an associative array
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

var_dump($result);