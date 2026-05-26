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


$userId = $userModel->create(
    "Lee",
    "Robin",
    "lee@gmail.com",
    "password"
);

$taskId = $taskModel->addTask(
    $userId,
    1,
    "Create Dashboard",
    "Build OOP dashboard system"
);

$subTaskModel->create(
    $taskId,
    "Create Navbar",
    "Pending"
);

$commentModel->create(
    $userId,
    $taskId,
    "approved by client"
);

echo "Inserted Successfully";

?>

