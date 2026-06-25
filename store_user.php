<?php

require_once "config/database.php";
require_once "models/User.php";

$db = (new Database())->connect();

$userModel = new User($db);

$userModel->create(
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['email'],
    $_POST['password'],
    $_POST['role']
);

header("Location: admin_dashboard.php");
exit;