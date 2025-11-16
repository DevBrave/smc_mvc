<?php

namespace Core;
use PDO;

class Database
{

    public $connection;
    public $statement;

    public function __construct($config, $username = 'root', $password = '')
    {

        $dsn = 'mysql:' . http_build_query($config, '', ';');
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

    public function fetch()
    {

        return $this->statement->fetch();
    }

    public function fetchCol()
    {
        return $this->statement->fetchColumn();
    }


    public function lastId()
    {
        return $this->connection->lastInsertId();
    }

    public function checkUniquness($table, $attribute_name, $attribute)
    {
        return $this->query("select count(*) from {$table} where $attribute_name=:$attribute_name", [
            $attribute_name => $attribute
        ])->fetch();

    }

    public function rollBack(){
        return $this->connection->rollBack();
    }

    public function  beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    public function commit()
    {
        return $this->connection->commit();

    }


}