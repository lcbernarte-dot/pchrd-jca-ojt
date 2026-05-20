<?php

class People {

    private $conn;
    private $table = "people";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getPeople() {

        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }

    // INSERT
    public function addPerson($firstname, $lastname, $email) {

        $sql = "INSERT INTO " . $this->table . "
                (firstname, lastname, email)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sss",
            $firstname,
            $lastname,
            $email
        );

        return $stmt->execute();
    }

    // UPDATE
    public function updatePerson($id, $firstname, $lastname, $email) {

        $sql = "UPDATE " . $this->table . "
                SET firstname = ?, lastname = ?, email = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $firstname,
            $lastname,
            $email,
            $id
        );

        return $stmt->execute();
    }

    // DELETE
    public function deletePerson($id) {

        $sql = "DELETE FROM " . $this->table . "
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>