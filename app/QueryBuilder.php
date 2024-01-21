<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{

    private $pdo;
    private $queryFactory;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=mysql; dbname=laravel;charset=utf8;", "user", "secret");
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getAll($table)
    {
        // $queryFactory = new QueryFactory('mysql');
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table);

        // $pdo = new PDO("mysql:host=mysql; dbname=laravel;charset=utf8;", "user", "secret");
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function findOne($id, $table)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id)
            ->limit(1);

        // var_dump($select->getStatement());die;

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        // Возвращаем одну запись или null, если ничего не найдено
        return $sth->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert($data, $table)
    {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)
            ->cols($data);

        // var_dump($insert->getStatement());
        // die;
        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function update($data, $id, $table)
    {
        $update = $this->queryFactory->newUpdate();
        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);

        // var_dump($update->getStatement());
        // die;
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete($id, $table)
    {
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        // var_dump($delete->getStatement());
        // die;

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }
}
