<?php

class Task {

    private $conn;
    private $table = "task";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getTask() {

        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }

    // INSERT
    public function addTask($task_name, $description, $status) {

        $sql = "INSERT INTO " . $this->table . "
                (task_name, description, status)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sss",
            $task_name,
            $description,
            $status
        );

        return $stmt->execute();
    }

    // UPDATE
    public function updateTask($id, $task_name, $description, $status) {

        $sql = "UPDATE " . $this->table . "
                SET task_name = ?, description = ?, status = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $task_name,
            $description,
            $status,
            $id
        );

        return $stmt->execute();
    }

    // DELETE
    public function deleteTask($id) {

        $sql = "DELETE FROM " . $this->table . "
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>