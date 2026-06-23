<?php

class Task {

    private $conn;
    private $table = "tasks";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTasks() {

        $sql = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addTask($user_id, $task, $description) {

        $sql = "INSERT INTO " . $this->table . "
                (user_id, task, description, status)
                VALUES (?, ?, ?, 'Pending')";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iss",
            $user_id,
            $task,
            $description,
        );

        if ($stmt->execute()) {
        return $this->conn->insert_id;
    }

        return false;
    }

    public function update($id, $task, $description, $status) {

        $sql = "UPDATE " . $this->table . "
                SET task = ?, description = ?, status = ?
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