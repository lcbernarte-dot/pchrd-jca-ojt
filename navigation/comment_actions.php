<?php

session_start();

require_once "../config/database.php";
require_once "../models/Comment.php";

$db = (new Database())->connect();

$comment = new Comment($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] == 'create') {

        if (
            $comment->create(
                $_POST['user_id'],
                $_POST['task_id'],
                $_POST['comment']
            )
        ) {

            $_SESSION['success'] =
                "✅ Comment added successfully!";

        } else {

            $_SESSION['error'] =
                "❌ Failed to add comment.";
        }

        header(
            "Location: ../task_details.php?id=" .
            $_POST['task_id']
        );
        exit;
    }

    if ($_POST['action'] == 'update') {

        $comment->update(
            $_POST['id'],
            $_POST['comment']
        );

        $_SESSION['success'] =
            "✅ Comment updated successfully!";

        header(
            "Location: ../task_details.php?id=" .
            $_POST['task_id']
        );
        exit;
    }
}

if (
    isset($_GET['action']) &&
    $_GET['action'] == 'delete'
) {

    $comment->delete($_GET['id']);

    $_SESSION['success'] =
        "✅ Comment deleted successfully!";

    header(
        "Location: ../task_details.php?id=" .
        $_GET['task_id']
    );
    exit;
}