<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/styles.css">
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Login Form</title>
</head>
<div class="body-login">
<body>
<div class="form-login">
    <form action="" method="post">
    <div class="login-container">
    <span class="title">Login</span>
        <div class="input-field">
        <i class="uil uil-envelope icon"></i>
        <input type="text" name="username" placeholder="Enter your username" required>
        </div>
        <div class="input-field">
        <i class="uil uil-lock icon"></i>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="input-field button">
            <input type="submit" name="login_submit" value="Login">
        </div>
    </div>
    </form>
    <div class="login-signup">
        <span class="text">Not a member? <a href="http://localhost/demo/register.php" class="text signup-text">Signup</a></span> 
    </div>
</div>
 
</body>
</div>
</html>
<?php
session_start();

include('db.php');

if (isset($_POST["login_submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('s', $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $password === $user["password"]) {
            $_SESSION["user_id"] = $user['user_id'];
                       
            // $_SESSION["username"] = $user['username'];
            header("Location: projectlists.php");
            
            exit();

        } else {
            $error = "Invalid username or password";
        } 
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
