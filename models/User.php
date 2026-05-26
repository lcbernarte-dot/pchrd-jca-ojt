<?php

class User {

    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(
        string $first_name,
        string $last_name,
        string $email,
        string $password
    ) {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO " . $this->table . "
                (first_name, last_name, email, password)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssss",
            $first_name,
            $last_name,
            $email,
            $hashedPassword
        );

        return $stmt->execute();
    }
        public function getUsers() {

        $sql = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
        }
    }

?>