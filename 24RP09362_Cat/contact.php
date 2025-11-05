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
<title>Contact - Karongi Library</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    min-height: 100vh;
}
.navbar-brand { font-weight: bold; font-size: 1.5rem; }
.hero-section { text-align: center; color: #fff; padding: 100px 20px; }
.hero-section h1 { font-size: 3rem; margin-bottom: 20px; }
.hero-section p { font-size: 1.2rem; margin-bottom: 40px; }
.btn-primary { border-radius: 50px; padding: 12px 30px; font-weight: bold; font-size: 1.1rem; }
.cards-section { padding: 60px 20px; }
.card { border-radius: 15px; transition: transform 0.3s ease; }
.card:hover { transform: translateY(-10px); }
.card-body h5 { font-weight: bold; }
.contact-form { max-width: 600px; margin: 0 auto; background: #ffffffcc; padding: 40px; border-radius: 15px; box-shadow: 0 15px 40px rgba(0,0,0,0.3); }
.contact-form input, .contact-form textarea { border-radius: 10px; padding: 12px; margin-bottom: 15px; width: 100%; }
.contact-form button { border-radius: 50px; font-weight: bold; }
.footer { text-align: center; padding: 30px 20px; color: #fff; background-color: #111; }
.alert { text-align:center; font-weight:bold; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">📚 Karongi Library</a>
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
    <h1>Contact Us</h1>
    <p>Have questions or feedback? Reach out to us using the form below.</p>
</section>

<!-- Contact Form Section -->
<section class="cards-section container">
    <div class="contact-form">
        <?php
        if(isset($_POST['send'])){
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);
            // Here you can handle storing the message or sending an email
            echo "<div class='alert alert-success'>Thank you, $name! Your message has been sent.</div>";
        }
        ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
            <button type="submit" name="send" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</section>

<!-- Footer -->
<div class="footer">
    &copy; <?php echo date('Y'); ?> Karongi Library. All rights reserved.
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
