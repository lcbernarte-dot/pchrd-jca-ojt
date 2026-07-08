<?php

session_start();

require_once "../config/database.php";
require_once "../models/SubTasks.php";

$db = (new Database())->connect();

$subtask = new SubTasks($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] == 'create') {

        if(
            $subtask->create(
                $_POST['task_id'],
                $_POST['sub_task'],
                $_POST['status']
            )
        ){

            $updateTask = $db->prepare(
                "UPDATE tasks SET updated_at = NOW() WHERE id = ?"
            );
            $updateTask->bind_param(
                "i",
                $_POST['task_id']
            );
            $updateTask->execute();

            $_SESSION['success'] =
                "✅ Sub Task added successfully!";

        } else {

            $_SESSION['error'] =
                "❌ Failed to add Sub Task.";

        }

        header(
            "Location: ../task_details.php?id=" .
            $_POST['task_id']
        );
        exit;
    }

    if ($_POST['action'] == 'update') {

    $stmt = $db->prepare("
        SELECT tasks.user_id
        FROM sub_tasks
        JOIN tasks
        ON sub_tasks.task_id=tasks.id
        WHERE sub_tasks.id=?
        ");

    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();

    $owner = $stmt->get_result()->fetch_assoc();

    if (
        $_SESSION['user_id'] != $owner['user_id']
        &&
        $_SESSION['role'] != "Administrator"
    ){
        die("Access Denied.");
    }

        $subtask->update(
            $_POST['id'],
            $_POST['sub_task'],
            $_POST['status']
        );

        $updateTask = $db->prepare(
            "UPDATE tasks SET updated_at = NOW() WHERE id = ?"
        );
        $updateTask->bind_param(
            "i",
            $_POST['task_id']
        );
        $updateTask->execute();

        header(
            "Location: ../task_details.php?id=" .
            $_POST['task_id']
        );
        exit;
    }

    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $stmt = $db->prepare("
        SELECT tasks.user_id
        FROM sub_tasks
        JOIN tasks
        ON sub_tasks.task_id=tasks.id
        WHERE sub_tasks.id=?
        ");

    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();

    $owner = $stmt->get_result()->fetch_assoc();

    if (
        $_SESSION['user_id'] != $owner['user_id']
        &&
        $_SESSION['role'] != "Administrator"
    ){
        die("Access Denied.");
    }

        $subtask->delete($_GET['id']);

        $updateTask = $db->prepare(
            "UPDATE tasks SET updated_at = NOW() WHERE id = ?"
        );
        $updateTask->bind_param(
            "i",
            $_GET['task_id']
        );
        $updateTask->execute();

        header(
            "Location: ../task_details.php?id=" .
            $_GET['task_id']
        );
        exit;
    }