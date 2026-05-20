<?php

class Database {

    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $database = "pchrd_ojt";
    private $port = 3306;

    public $conn;

    public function connect() {

        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->port
        );

        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}

?>