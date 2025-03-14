<?php 
include('./conn/conn.php'); 

// If user is already logged in, redirect to home dashboard
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Registration and Login System</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/style.css" />

    <!-- Bootstrap CSS (for styling, optional) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
</head>
<body>
    <div class="main">
        <!-- Login Area -->
        <div class="login" id="loginForm">
            <h1 class="text-center">Login Form</h1>
            <div class="login-form">
                <form action="./endpoint/login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <p class="registrationForm" onclick="showRegistrationForm()">No Account? Register Here.</p>
                    <button type="submit" class="btn btn-dark login-btn form-control">Login</button>
                </form>
            </div>
        </div>

        <!-- Registration Area -->
        <div class="registration" id="registrationForm" style="display:none;">
            <h1 class="text-center">Registration Form</h1>
            <div class="registration-form">
                <form action="./endpoint/add-user.php" method="POST">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="col-6">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-5">
                            <label for="contactNumber">Contact Number:</label>
                            <input type="number" class="form-control" id="contactNumber" name="contact_number" maxlength="11" required>
                        </div>
                        <div class="col-7">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerUsername">Username:</label>
                        <input type="text" class="form-control" id="registerUsername" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Password:</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" required>
                    </div>
                    <p class="registrationForm" onclick="showLoginForm()">&larr; Back to Login</p>
                    <button type="submit" class="btn btn-dark login-register form-control">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle between Login and Registration forms
        const loginForm = document.getElementById('loginForm');
        const registrationForm = document.getElementById('registrationForm');
        function showRegistrationForm() {
            registrationForm.style.display = "";
            loginForm.style.display = "none";
        }
        function showLoginForm() {
            registrationForm.style.display = "none";
            loginForm.style.display = "";
        }
    </script>
    <!-- Bootstrap JS (optional, for completeness) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
