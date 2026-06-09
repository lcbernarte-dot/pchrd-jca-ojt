<?php

class SubTasks {

    private $conn;
    private $table = "sub_tasks";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {

        $sql = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->get_result();
    }


    public function create($task_id, $sub_task, $status) {

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

    public function update($id, $sub_task, $status) {

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

    public function delete($id) {

        $sql = "DELETE FROM " . $this->table . "
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>