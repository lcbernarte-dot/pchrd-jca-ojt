<?php

session_start();

require_once "../config/database.php";
require_once "../models/Task.php";

$db = (new Database())->connect();
$task = new Task($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'create') {

        $task_id = $task->addTask(
            $_SESSION['user_id'],
            $_POST['task'],
            $_POST['description']
        );

        if ($task_id) {
            $_SESSION['success'] = "Task added successfully!";
            header("Location: ../task_details.php?id=" . $task_id);
            exit;
        }

        $_SESSION['error'] = "Failed to add task.";
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update') {

    $stmt = $db->prepare("SELECT user_id FROM tasks WHERE id=?");
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

        $task->update(
            $_POST['id'],
            $_POST['task'],
            $_POST['description'],
            $_POST['status']
        );

        $_SESSION['success'] = "Task updated successfully!";
        header("Location: ../task_details.php?id=" . $_POST['id']);
        exit;
    }

    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete') {

    $stmt = $db->prepare("SELECT user_id FROM tasks WHERE id=?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();

    $owner = $stmt->get_result()->fetch_assoc();

    if (
        $_SESSION['user_id'] != $owner['user_id']
        &&
        $_SESSION['role'] != "Administrator"
    ){
        die("Access Denied.");
    }

        $task->delete($_GET['id']);

        $_SESSION['success'] = "Task deleted successfully!";
        header("Location: ../index.php");
        exit;
    }