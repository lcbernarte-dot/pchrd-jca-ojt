<?php
session_start();

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'Administrator'
) {
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


    <a href="admin_dashboard.php" class="cancel-btn">
        Cancel
    </a>


</form>

</body>
</html>     