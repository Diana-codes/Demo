
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/styles.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Registration Form</title>
</head>
<body>
<div class="form-register">
    <form action="register.php" method="post">
        <!-- Registration form fields here -->
        <div class="container-register">
        <span class="title">Registration</span>
        <div class="input-field">
        <i class="uil uil-user icon"></i>
            <input type="text" name="register_name" placeholder="Your Name" required>
        </div>
        <div class="input-field">
        <i class="uil uil-lock icon"></i>
            <input type="password" name="register_password" placeholder="Create a password" required>
        </div>
        <div class="input-field">
        <i class="uil uil-lock icon"></i>
            <input type="password" name="register_password" placeholder="Confirm a password" required>
            <i class="uil uil-eye-slash showHidePw"></i>
        </div>
        <div class="input-field button">
            <input type="submit" name="register_submit" value="Register">
        </div>
    </form>
    <div class="register-signup">
        <span class="text">Already a member? <a href="http://localhost/demo/login.php" class="text signup-text">Login</a></span>
    </div>
</div>
</div>
</body>
</html>
<?php
session_start();

include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_submit'])) {
    $name = $_POST['register_name'];
    $password = $_POST['register_password'];

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$name, $password]);

        header("Location:homepage.php");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

