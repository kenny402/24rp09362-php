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
<title>Home - Exam System</title>
<<link href="/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    min-height: 100vh;
}
.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
}
.hero-section {
    text-align: center;
    color: #fff;
    padding: 100px 20px;
}
.hero-section h1 {
    font-size: 3rem;
    margin-bottom: 20px;
}
.hero-section p {
    font-size: 1.2rem;
    margin-bottom: 40px;
}
.btn-primary {
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: bold;
    font-size: 1.1rem;
}
.cards-section {
    padding: 60px 20px;
}
.card {
    border-radius: 15px;
    transition: transform 0.3s ease;
}
.card:hover {
    transform: translateY(-10px);
}
.card-body h5 {
    font-weight: bold;
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
    <a class="navbar-brand" href="#">📚 Karongi library_system</a>
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

<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
    <p>Your ultimate platform for managing Karongi library_system and users efficiently.</p>
    <a href="#" class="btn btn-primary">Get Started</a>
</section>

<!-- Cards Section -->
<section class="cards-section container">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-lg p-3">
        <div class="card-body text-center">
          <h5>Any user </h5>
          <p>just relax for my design.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-lg p-3">
        <div class="card-body text-center">
          <h5>Books we gat for u</h5>
          <p>Design and manage books efficiently with full control.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-lg p-3">
        <div class="card-body text-center">
          <h5>Track Progress</h5>
          <p>students who have books.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<div class="footer">
    &copy; <?php echo date('Y'); ?> Karongi library_system. All rights reserved.
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
