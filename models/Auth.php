<?php

class Auth
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        $user = $result->fetch_assoc();

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }
}