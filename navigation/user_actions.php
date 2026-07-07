<?php

session_start();

require_once "../config/database.php";

$db = (new Database())->connect();

if (
    isset($_GET['action']) &&
    $_GET['action'] == 'delete'
) {

    $id = $_GET['id'];

    if ($id == $_SESSION['user_id']) {

        $_SESSION['error'] =
            "You cannot delete your own account.";

        header("Location: ../admin_dashboard.php");
        exit;
    }

    $stmt = $db->prepare(
        "DELETE FROM comments WHERE user_id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $db->prepare(
        "DELETE st
         FROM sub_tasks st
         INNER JOIN tasks t
         ON st.task_id = t.id
         WHERE t.user_id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $db->prepare(
        "DELETE c
         FROM comments c
         INNER JOIN tasks t
         ON c.task_id = t.id
         WHERE t.user_id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $db->prepare(
        "DELETE FROM tasks WHERE user_id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $db->prepare(
        "DELETE FROM users WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] =
        "User deleted successfully.";

    header("Location: ../admin_dashboard.php");
    exit;
}