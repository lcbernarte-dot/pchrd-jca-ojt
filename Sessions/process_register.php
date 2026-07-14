<?php

session_start();

require_once "../config/database.php";

$db = (new Database())->connect();

$first_name = trim($_POST['first_name']);
$last_name  = trim($_POST['last_name']);
$email      = trim($_POST['email']);
$password   = $_POST['password'];
$role       = "user";

$check = $db->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check->bind_param("s", $email);
$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){

    $_SESSION['error'] = "Email already exists.";

    header("Location: ../register.php");
    exit;
}

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $db->prepare(
    "INSERT INTO users
    (first_name,last_name,email,password,role)
    VALUES (?,?,?,?,?)"
);

$stmt->bind_param(
    "sssss",
    $first_name,
    $last_name,
    $email,
    $hashedPassword,
    $role
);

if($stmt->execute()){

    $_SESSION['success'] =
        "Registration successful. You may now login.";

}else{

    $_SESSION['error'] =
        "Registration failed.";

}

header("Location: ../register.php");
exit;