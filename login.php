<?php
session_start();
include 'config.php';

if(isset($_POST['username'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if($password === $row['password']){
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit;
        } 
        else {
            $error = "Invalid password";
        }
    }
    else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - Manakamana Furniture</title>
<link rel="icon" href="images/icon.png">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-box">
<h2>Login</h2>
<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<input type="submit" value="Login">
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</form>
</div>
</body>
</html>
