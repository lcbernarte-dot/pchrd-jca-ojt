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

    public function addTask($user_id, $task, $description, $status) {

        $sql = "INSERT INTO " . $this->table . "
                (user_id, task, description, status)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "isss",
            $user_id,
            $task,
            $description,
            $status
        );

        if ($stmt->execute()) {
        return $this->conn->insert_id;
    }

        return false;
    }

    public function update($id, $task, $description, $status) {

        $sql = "UPDATE " . $this->table . "
                SET task = ?, description = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $task,
            $description,
            $status,
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