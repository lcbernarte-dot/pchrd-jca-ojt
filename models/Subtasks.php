<?php

class SubTasks {

    private $conn;
    private $table = "sub_tasks";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getSubTasks() {

        $sql = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->get_result();
    }

    // INSERT
    public function addSubTask($task_id, $sub_task, $status) {

        $sql = "INSERT INTO " . $this->table . "
                (task_id, sub_task, status)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iss",
            $task_id,
            $sub_task,
            $status
        );

        return $stmt->execute();
    }

    // UPDATE
    public function updateSubTask($id, $sub_task, $status) {

        $sql = "UPDATE " . $this->table . "
                SET sub_task = ?, status = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssi",
            $sub_task,
            $status,
            $id
        );

        return $stmt->execute();
    }

    // DELETE
    public function deleteSubTask($id) {

        $sql = "DELETE FROM " . $this->table . "
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>