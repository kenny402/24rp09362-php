<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "library_system");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Handle borrow form submission (insert or update)
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow_book'])){
    $book_id    = $_POST['book_id'];
    $name       = $_POST['name'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $department = $_POST['department'];
    $user_id    = $_SESSION['user_id'];

    // Check if this user already borrowed this book
    $check = $conn->prepare("SELECT id FROM borrowed_books WHERE user_id=? AND book_id=?");
    $check->bind_param("ii", $user_id, $book_id);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        // Already borrowed: update the record
        $check->bind_result($borrow_id);
        $check->fetch();
        $stmt = $conn->prepare("UPDATE borrowed_books SET name=?, phone=?, email=?, department=?, borrow_date=NOW() WHERE id=?");
        $stmt->bind_param("ssssi", $name, $phone, $email, $department, $borrow_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Not borrowed yet: insert new record
        $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, name, borrow_date, phone, email, department) VALUES (?, ?, ?, NOW(), ?, ?, ?)");
        $stmt->bind_param("iissss", $user_id, $book_id, $name, $phone, $email, $department);
        $stmt->execute();
        $stmt->close();
    }

    $check->close();

    // Redirect to borrowed page
    header("Location: borrowed.php");
    exit();
}

// Fetch books
$books_result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Books - Library System</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(to right, #0f2027, #203a43, #2c5364); min-height: 100vh; }
.navbar-brand { font-weight: bold; font-size: 1.5rem; }
.hero-section { text-align: center; color: #fff; padding: 50px 20px; }
.btn-primary { border-radius: 50px; padding: 10px 25px; font-weight: bold; font-size: 1rem; }
.cards-section { padding: 40px 20px; }
.card { border-radius: 15px; transition: transform 0.3s ease; }
.card:hover { transform: translateY(-10px); }
.card-body h5 { font-weight: bold; }
.borrow-form { margin-top: 15px; display: none; }
.footer { text-align: center; padding: 30px 20px; color: #fff; background-color: #111; }
</style>
<script>
function toggleForm(id){
    let form = document.getElementById('form-' + id);
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}
</script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">📚 Karongi Library System</a>
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

<section class="hero-section">
    <h1>Available Books</h1>
    <p>Select a book to borrow and fill in your details.</p>
</section>

<section class="cards-section container">
  <div class="row g-4">
    <?php if($books_result->num_rows > 0): ?>
        <?php while($book = $books_result->fetch_assoc()): ?>
        <div class="col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-body">
                    <h5><?php echo htmlspecialchars($book['title']); ?></h5>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
                    <p><strong>Published:</strong> <?php echo $book['published_year']; ?></p>
                    <p><strong>Stock:</strong> <?php echo $book['stock']; ?></p>
                    <button class="btn btn-primary" onclick="toggleForm(<?php echo $book['id']; ?>)">Borrow / Update</button>

                    <!-- Borrow / Update Form -->
                    <form id="form-<?php echo $book['id']; ?>" class="borrow-form" method="POST">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <div class="mb-2">
                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-2">
                            <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-2">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control" name="department" placeholder="Department" required>
                        </div>
                        <button type="submit" name="borrow_book" class="btn btn-success w-100">Submit</button>
                    </form>

                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-white">No books available.</p>
    <?php endif; ?>
  </div>
</section>

<div class="footer">
    &copy; <?php echo date('Y'); ?> Karongi Library System
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
