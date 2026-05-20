<?php

class Comment {

    private $conn;
    private $table = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getComments() {

        $sql = "
            SELECT 
                comments.id,
                comments.comment,
                comments.created_at,
                sub_tasks.sub_task,
                sub_tasks.status

            FROM comments

            INNER JOIN sub_tasks
            ON comments.sub_task_id = sub_tasks.id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->get_result();
    }

    // INSERT
    public function addComment($sub_task_id, $comment) {

        $sql = "INSERT INTO " . $this->table . "
                (sub_task_id, comment)
                VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "is",
            $sub_task_id,
            $comment
        );

        return $stmt->execute();
    }

    // UPDATE
    public function updateComment($id, $comment) {

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

    // DELETE
    public function deleteComment($id) {

        $sql = "DELETE FROM " . $this->table . "
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>