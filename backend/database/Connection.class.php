<?php

class Connection
{
    private $connection;

    public function __construct()
    {
        $this->connection = $this->connectionDb();
    }

    private function connectionDb()
    {
        $host = 'db';
        $dbname = 'taskdb';
        $user = 'user';
        $pass = 'password';

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            return ("Failure to connect on database: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
