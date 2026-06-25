<?php

session_start();

require_once "../config/database.php";
require_once "../models/Auth.php";

$database = new Database();
$db = $database->connect();

$auth = new Auth($db);

$email = $_POST['email'];
$password = $_POST['password'];

$user = $auth->login($email, $password);

if ($user) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'Administrator' || $user['role'] === 'admin') {

        header("Location: ../admin_dashboard.php");
    } else {
        header("Location: ../user_task_manager.php");
    }
    exit;
    }

echo "Invalid Email or Password";