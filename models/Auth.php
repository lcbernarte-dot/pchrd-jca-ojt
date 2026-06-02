<?php

session_start();

require_once "../config/database.php";

$database = new Database();
$db = $database->connect();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){

    $user = $result->fetch_assoc();

    if(password_verify($password, $user['password'])){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['email'] = $user['email'];

        header("Location: ../index.php");
        exit;

    } else {

    echo "Invalid Password";

}

    } else {

    echo "User Not Found";
    

}