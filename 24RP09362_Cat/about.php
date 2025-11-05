<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About - Karongi_library_system</title>
<link href="css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    min-height: 100vh;
    color: #fff;
}
.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
}
.section {
    padding: 80px 20px;
    text-align: center;
}
.section h1 {
    font-size: 3rem;
    margin-bottom: 20px;
}
.section p {
    font-size: 1.2rem;
    margin-bottom: 40px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}
.footer {
    text-align: center;
    padding: 30px 20px;
    color: #fff;
    background-color: #111;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <!-- <a class="navbar-brand" href="home.php">Karongi library_system</a> -->
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
               <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="books.php">Books</a></li>
        <li class="nav-item"><a class="nav-link" href="borrowed.php">Borrowed Books</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- About Section -->
<section class="section">
    <h1>About Karingi_library_system</h1>
    <p>Welcome, <?php echo $_SESSION['user']; ?>! This platform is designed to provide a seamless experience for managing library, users, and books. You can store , monitor books, and manage all user accounts efficiently, all from one centralized system. Our goal is to make Karingi_library_system simple, professional, and effective.</p>
    <p>Whether you are an administrator, teacher, or student, this system provides you with the tools you need to excel. Enjoy an intuitive interface, real-time tracking, and a secure environment for all your academic needs.</p>
</section>

<!-- Footer -->
<div class="footer">
    &copy; <?php echo date('Y'); ?> Karongi_library_system. All rights reserved.
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
