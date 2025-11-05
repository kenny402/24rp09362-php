<?php
include 'db.php';

if(isset($_POST['signup'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email or username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=? OR username=?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $error = "Username or Email already registered!";
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if($stmt->execute()){
            echo "<script>alert('Account created successfully!'); window.location='login.php';</script>";
            exit();
        } else {
            $error = "Something went wrong!";
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: linear-gradient(135deg, #1f4037, #99f2c8); height: 100vh; display: flex; justify-content: center; align-items: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.signup-card { width: 100%; max-width: 450px; background: #ffffffcc; padding: 40px; border-radius: 15px; box-shadow: 0 15px 40px rgba(0,0,0,0.3); }
.signup-card .card-header { background: linear-gradient(to right, #0d6efd, #00c6ff); border-radius: 10px 10px 0 0; color: white; font-weight: bold; text-align: center; font-size: 1.5rem; }
.signup-card input { border-radius: 10px; padding: 15px; font-size: 1rem; }
.signup-card button { border-radius: 50px; font-weight: bold; padding: 12px; font-size: 1.1rem; transition: all 0.3s ease; }
.signup-card .card-footer { text-align: center; margin-top: 20px; font-size: 0.95rem; }
.alert { text-align: center; margin-bottom: 15px; font-weight:bold; color:red; }
</style>
</head>
<body>
<div class="signup-card card shadow-lg">
    <div class="card-header">Sign Up</div>
    <div class="card-body">
        <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" placeholder="Username" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" placeholder="Email" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary w-100">Sign Up</button>
        </form>
    </div>
    <div class="card-footer">
        Already have an account? <a href="login.php">Login Here</a>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
