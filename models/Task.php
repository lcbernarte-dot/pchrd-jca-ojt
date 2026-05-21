<?php

class Task {

    private $conn;
    private $table = "tasks";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createTask() {

        $sql = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->get_result();
    }

    public function addTask($user_id, $task_name, $description) {

        $sql = "INSERT INTO " . $this->table . "
                (user_id, task_name, description)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iss",
            $user_id,
            $task_name,
            $description
        );

        return $stmt->execute();
    }

    public function update($id, $task_name, $description) {

        $sql = "UPDATE " . $this->table . "
                SET task_name = ?, description = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssi",
            $task_name,
            $description,
            $id
        );

        return $stmt->execute();
    }

    public function delete($id) {

        $sql = "DELETE FROM " . $this->table . "
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>