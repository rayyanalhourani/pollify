<?php

namespace Core;

use PDO;

class Database
{
    public $connection;
    public $statement;

    public function __construct($HOST,$DBNAME,$CHARSET,$USER,$PASSWORD)
    {

        $dsn = "mysql:host=$HOST;dbname=$DBNAME;charset=$CHARSET";

        $this->connection = new PDO($dsn, $USER, $PASSWORD, [
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        if (strpos($query, 'INSERT') === 0) {
            return $this->connection->lastInsertId();
        }

        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (! $result) {
            abort();
        }

        return $result;
    }
}
