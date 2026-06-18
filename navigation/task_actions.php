<?php

session_start();

require_once "../config/database.php";
require_once "../models/Task.php";

$db = (new Database())->connect();

$task = new Task($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if ($_POST['action'] == 'create') {

    $task_id = $task->addTask(
        $_POST['user_id'],
        $_POST['task'],
        $_POST['description']
    );
    if($task_id){

    $_SESSION['success'] = "Task added successfully!";

    header("Location: ../task_details.php?id=" . $task_id);
    exit;
    }

    }else{

        $_SESSION['error'] =
            "❌ Failed to add task.";

    }

}

    if ($_POST['action'] == 'update') {

        $task->update(
            $_POST['id'],
            $_POST['task'],
            $_POST['description'],
            $_POST['status']
        );

    }

    if (isset($_GET['action'])&& $_GET['action'] == 'delete') 
    {
        $task->delete($_GET['id']);
    }

