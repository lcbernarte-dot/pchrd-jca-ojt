<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Sessions/login.php");
    exit;
}

?>

<?php

require_once "config/database.php";
require_once "models/User.php";
require_once "models/Task.php";
require_once "models/SubTasks.php";
require_once "models/Comment.php";

$database = new Database();
$db = $database->connect();

$userModel = new User($db);
$taskModel = new Task($db);
$subTaskModel = new SubTasks($db);
$commentModel = new Comment($db);

$userResult = $userModel->getUsers();
$taskResult = $taskModel->getTasks();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php if(isset($_SESSION['success'])): ?>

    <div class="notification success">
    <?= $_SESSION['success']; ?>
    </div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if(isset($_SESSION['error'])): ?>

    <div class="notification error">
    <?= $_SESSION['error']; ?>
    </div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>    


<div class="container">

    <div class="header">
        <h1>Task Manager</h1>

    <div class="header-actions">

        <a href="Sessions/logout.php" class="logout-btn">
            Logout
        </a>
    </div>
</div>
    
<div class="user-box">

    <div class="profile-icon">
        👤
    </div>

    <div class="user-info">

        <span> Welcome, </span><br>

        <strong>
            <?= $_SESSION['first_name']; ?>
            <?= $_SESSION['last_name']; ?>
        </strong>

        <span>
            (ID: <?= $_SESSION['user_id']; ?>)
        </span>

    </div>

</div>
    
<div class="card">

        <h2>Add Task</h2>

        <form action="navigation/task_actions.php" method="POST">

            <input
                type="hidden"
                name="action"
                value="create"
            >
            <input
                type="hidden"
                name="user_id"
                value="<?= $_SESSION['user_id']; ?>"
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
    <?php include "views/TaskViews.php"; ?>

</div>

    <script>

    setTimeout(() => {

    const notif = document.querySelector('.notification');

    if(notif){
        notif.style.display = 'none';
    }

    }, 3000);

    </script>

</body>

