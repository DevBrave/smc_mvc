<?php

namespace Core;
use Exception as Exception;
use PDO;

class Database
{

    public $pdo;
    public $statement;

    public function __construct($config, $username = 'root', $password = '')
    {

        $dsn = 'mysql:' . http_build_query($config, '', ';');
        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public function query($query, $params = []): Database
    {
        $this->statement = $this->pdo->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    // If you call a method that doesn't exist (like 'rowCount'),

    /**
     * @throws Exception
     */
    public function __call($method, $args)
    {
        // 1. Check if the STATEMENT can handle this method
        if ($this->statement && method_exists($this->statement, $method)) {
            return call_user_func_array([$this->statement, $method], $args);
        }

        // 2. Check if the PDO CONNECTION can handle this method
        if (method_exists($this->pdo, $method)) {
            return call_user_func_array([$this->pdo, $method], $args);
        }

        // 3. If neither knows it, throw an error
        throw new Exception("Method {$method} does not exist on Database or PDO.");
    }
    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }

    public function checkUniqueness($table, $attribute_name, $attribute)
    {
        return $this->query("select count(*) from {$table} where $attribute_name=:$attribute_name", [
            $attribute_name => $attribute
        ])->fetch();

    }

    /**
     * @throws Exception
     */
    public function findOrFail(){

        $result = $this->statement->fetch();

        if (! $result) {
            throw new Exception('Record not found', 404);
        }

        return $result;

    }



}