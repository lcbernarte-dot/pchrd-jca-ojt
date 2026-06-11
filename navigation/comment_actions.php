<?php

require_once "../config/database.php";
require_once "../models/Comment.php";

$db = (new Database())->connect();

$comment = new Comment($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] == 'create') {

        $comment->create(
            $_POST['user_id'],
            $_POST['task_id'],
            $_POST['comment']
        );

    }

    if ($_POST['action'] == 'update') {

        $comment->update(
            $_POST['id'],
            $_POST['comment']
        );

    }

}

if (
    isset($_GET['action'])
    &&
    $_GET['action'] == 'delete'
) {

    $comment->delete($_GET['id']);

}

header("Location: ../index.php");
exit;