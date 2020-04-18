<?php

class Database
{
    private $databaseName = "restaurant";
    private $databaseUserName = "root";
    private $databasePassword = "";
    private $host = "localhost";
    private $connection;

    public function initializeConnection()
    {
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->databaseName, $this->databaseUserName, $this->databasePassword);
            $this->connection->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connection;
    }
}
