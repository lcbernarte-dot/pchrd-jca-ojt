<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: Sessions/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
</head>
<body>

<h2>Create User</h2>

<form action="store_user.php" method="POST">

    <input
        type="text"
        name="first_name"
        placeholder="First Name"
        required
    >

    <input
        type="text"
        name="last_name"
        placeholder="Last Name"
        required
    >

    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">
        Create User
    </button>

</form>

</body>
</html>     