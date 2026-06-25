<?php

session_start();

require_once "config/database.php";
require_once "models/User.php";

$db = (new Database())->connect();

$userModel = new User($db);

$userResult = $userModel->getUsers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="header">

        <h1></h1>   
        
        <div class="header-actions">

        <a href="admin_dashboard.php" class="users-btn">
            Back
        </a>

    </div>
</div>
    <?php include "views/UserViews.php"; ?>

</body>
</html>