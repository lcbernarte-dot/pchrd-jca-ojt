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
                $_SESSION['user_id'],
                $_POST['task_id'],
                $_POST['comment']
            )
        ) {

            $updateTask = $db->prepare(
                "UPDATE tasks SET updated_at = NOW() WHERE id = ?"
            );
            $updateTask->bind_param(
                "i",
                $_POST['task_id']
            );
            $updateTask->execute();

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

        $stmt = $db->prepare(
            "SELECT user_id FROM comments WHERE id=?"
            );

        $stmt->bind_param("i",$_POST['id']);
        $stmt->execute();

        $owner=$stmt->get_result()->fetch_assoc();

        if(
        $_SESSION['user_id']!=$owner['user_id']
        &&
        $_SESSION['role']!="Administrator"
        ){
            die("Access Denied.");
        }

        $comment->update(
            $_POST['id'],
            $_POST['comment']
        );

        $updateTask = $db->prepare(
            "UPDATE tasks SET updated_at = NOW() WHERE id = ?"
        );
        $updateTask->bind_param(
            "i",
            $_POST['task_id']
        );
        $updateTask->execute();

        $_SESSION['success'] =
            "✅ Comment updated successfully!";

        header(
            "Location: ../task_details.php?id=" .
            $_POST['task_id']
        );
        exit;
    }

    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete') {

        $stmt = $db->prepare(
            "SELECT user_id FROM comments WHERE id=?"
            );

        $stmt->bind_param("i",$_GET['id']);
        $stmt->execute();

        $owner=$stmt->get_result()->fetch_assoc();
        
        if (!$owner) {
            die("Comment not found.");
        }

        if(
        $_SESSION['user_id']!=$owner['user_id']
        &&
        $_SESSION['role']!="Administrator"
        ){
            die("Access Denied.");
        }

        $comment->delete($_GET['id']);

        $updateTask = $db->prepare(
            "UPDATE tasks SET updated_at = NOW() WHERE id = ?"
        );
        $updateTask->bind_param(
            "i",
            $_GET['task_id']
        );
        $updateTask->execute();

        $_SESSION['success'] =
            "✅ Comment deleted successfully!";

        header(
            "Location: ../task_details.php?id=" .
            $_GET['task_id']
        );
        exit;
    }