<?php

session_start();

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'Administrator'
) {
    header("Location: Sessions/login.php");
    exit;
}

require_once "config/database.php";
require_once "models/User.php";

$db = (new Database())->connect();

$userModel = new User($db);
$userResult = $userModel->getUsers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="header">
        <h1>Admin Dashboard</h1>

        <div class="header-actions">

            <a href="create_user.php" class="users-btn">
                Create User
            </a>

            <a href="Sessions/logout.php" class="logout-btn">
                Logout
            </a>

        </div>
        
    </div>

    <div class="user-box">
        <div class="profile-icon">👤</div>

        <div class="user-info">
            Welcome,<br>

            <strong>
                <?= $_SESSION['first_name']; ?>
            </strong>

            <span>
                (ID: <?= $_SESSION['user_id']; ?>)
            </span>
        </div>
    </div>

    <div class="card">

        <h2>Add Task</h2>

        <form action="navigation/task_actions.php" method="POST">

            <input type="hidden" name="action" value="create">

            <input
                type="number"
                name="user_id"
                placeholder="User ID"
                required
            >

            <input
                type="text"
                name="task"
                placeholder="Task Name"
                required
            >

            <input
                type="text"
                name="description"
                placeholder="Description"
                required
            >

            <button type="submit">
                Add Task
            </button>

        </form>

    </div>
    
            <?php include "views/UserViews.php"; ?>
</div>



</body>
</html>