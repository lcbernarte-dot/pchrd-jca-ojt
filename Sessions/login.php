<?php

session_start();

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] === 'Administrator') {
        header("Location: ../admin_dashboard.php");
    } else {
        header("Location: ../user_task_manager.php");
    }

    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

    <div class="card login-card">

        <h1>Login</h1>

        <form action="process_login.php" method="POST" class="login-form">

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

            <div class="login-actions">

                <button type="submit" class="login-btn">
                    Login
                </button>

                <a href="../register.php" class="register-btn">
                    Register   
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>