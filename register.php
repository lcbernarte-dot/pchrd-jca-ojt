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

    <div class="card register-card">

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

        <form action="Sessions/process_register.php" method="POST" class="register-form">

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

            <div class="password-group">

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    oninput="toggleEye('password','eye1')"
                    required
                >
                <span id="eye1" class="toggle-password" onclick="togglePassword('password','eye1')">👁</span>

            </div>

            <div id="confirmPasswordBox" style="display:none;">

                <div class="password-group">
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Re-enter Password"
                        oninput="toggleEye('confirm_password','eye2')"
                        required
                    >

                    <span id="eye2"
                        class="toggle-password"
                        onclick="togglePassword('confirm_password','eye2')">
                        👁
                    </span>

                </div>

            </div>

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

    <script>
    function toggleEye(inputId, eyeId){

        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);

        if(input.value.length > 0){
            eye.style.display = "block";
        }else{
            eye.style.display = "none";
            input.type = "password";
            eye.textContent = "👁";
        }
    }

    function togglePassword(inputId, eyeId){

        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);

        if(input.type === "password"){
            input.type = "text";
            eye.textContent = "⌣";
        }else{
            input.type = "password";
            eye.textContent = "👁";
        }
    }

        const password = document.getElementById("password");
        const confirmBox = document.getElementById("confirmPasswordBox");

    password.addEventListener("blur", function () {

        if (this.value.trim() !== "") {
            confirmBox.style.display = "block";
        } else {
            confirmBox.style.display = "none";
        }

    });
    </script>

</body>
</html>