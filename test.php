<?php

require_once "config/database.php";
require_once "models/Users.php";
require_once "models/Task.php";
require_once "models/SubTasks.php";

$database = new Database();
$db = $database->connect();

$userModel = new User($db);
$taskModel = new Task($db);
$subTaskModel = new SubTasks($db);
$commentModel = new Comment($db);


$userModel->create(
    "Lee",
    "Robin",
    "lee@gmail.com",
    "password"
);


$taskModel->addTask(
    1,
    "Create Dashboard",
    "Build OOP dashboard system"
);


$subTaskModel->create(
    1,
    "Create Navbar",
    "Pending"
);

$commentModel->create(
    1,
    "Create Dashboard",
    "approved by client"

);

echo "Inserted Successfully";

?>

