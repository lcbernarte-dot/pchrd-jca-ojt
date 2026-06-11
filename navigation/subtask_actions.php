<?php

require_once "../config/database.php";
require_once "../models/SubTasks.php";

$db = (new Database())->connect();

$subtask = new SubTasks($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] == 'create') {

        $subtask->create(
            $_POST['task_id'],
            $_POST['sub_task'],
            $_POST['status']
        );

    }

    if ($_POST['action'] == 'update') {

        $subtask->update(
            $_POST['id'],
            $_POST['sub_task'],
            $_POST['status']
        );

    }

}

if (
    isset($_GET['action'])
    &&
    $_GET['action'] == 'delete'
) {

    $subtask->delete($_GET['id']);

}

header("Location: ../index.php");
exit;