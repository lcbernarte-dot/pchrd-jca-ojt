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

if (
    isset($_GET['action']) &&
    $_GET['action'] == 'delete'
) {

    $subtask->delete($_GET['id']);

    // UPDATE TASK updated_at
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