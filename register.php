<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="card">

        <h2>Create Account</h2>

        <?php
        if(isset($_SESSION['error'])){
            echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }

        if(isset($_SESSION['success'])){
            echo "<p style='color:green'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }
        ?>

        <form action="Sessions/process_register.php" method="POST">

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

            <input
                type="hidden"
                name="role"
                value="user"
            >

            <button type="submit">
                Register
            </button>

        </form>

        <br>

        <a href="Sessions/login.php">
            Already have an account?
        </a>

    </div>

</div>

</body>
</html>