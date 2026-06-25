<?php

require_once "config/database.php";
require_once "models/User.php";

$database = new Database();
$db = $database->connect();

$user = new User($db);

$user1 = $user->create(
    "Lee",
    "Robin",
    "lee@gmail.com",
    "password"
);

$user2 = $user->create(
    "admin",
    "",
    "admin@gmail.com",
    "password",
    "Administrator"
);

echo "Users Created";