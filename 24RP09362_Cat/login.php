<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $username_or_email = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if($stmt->num_rows == 1){
        $stmt->fetch();
        if(password_verify($password, $hashed_password)){
            $_SESSION['user_id'] = $id;
            $_SESSION['user'] = $username_or_email;
            header("Location: books.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: linear-gradient(135deg, #1f4037, #99f2c8); height: 100vh; display: flex; justify-content: center; align-items: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.login-card { width: 100%; max-width: 400px; background: #ffffffcc; padding: 40px; border-radius: 15px; box-shadow: 0 15px 40px rgba(0,0,0,0.3); }
.login-card .card-header { background: linear-gradient(to right, #0d6efd, #00c6ff); border-radius: 10px 10px 0 0; color: white; font-weight: bold; text-align: center; font-size: 1.5rem; }
.login-card input { border-radius: 10px; padding: 15px; font-size: 1rem; }
.login-card button { border-radius: 50px; font-weight: bold; padding: 12px; font-size: 1.1rem; transition: all 0.3s ease; }
.login-card .card-footer { text-align: center; margin-top: 20px; font-size: 0.95rem; }
.alert { text-align: center; margin-bottom: 15px; font-weight:bold; color:red; }
</style>
</head>
<body>
<div class="login-card card shadow-lg">
    <div class="card-header">Login</div>
    <div class="card-body">
        <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username_or_email" placeholder="Username or Email" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <div class="card-footer">
        Don't have an account? <a href="sign_up.php">Sign Up</a>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
