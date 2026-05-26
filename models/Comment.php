<?php

class Comment {

    private $conn;
    private $table = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getComment() {

        $sql = "
            SELECT 
                comments.id,
                comments.user_id,
                comments.task_id,
                comments.comment,
                comments.created_at,
                tasks.task

            FROM comments

            INNER JOIN tasks
            ON comments.task_id = tasks.id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->get_result();
    }

    public function create($user_id, $task_id, $comment) {

        $sql = "INSERT INTO " . $this->table . "
                (user_id, task_id, comment)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iis",
            $user_id,
            $task_id,
            $comment
        );

        return $stmt->execute();
    }

    public function update($id, $comment) {

        $sql = "UPDATE " . $this->table . "
                SET comment = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "si",
            $comment,
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