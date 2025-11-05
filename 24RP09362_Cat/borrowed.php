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

// Handle deletion
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']); // sanitize ID
    $stmt = $conn->prepare("DELETE FROM borrowed_books WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']); // ensure user can delete only their own records
    $stmt->execute();
    $stmt->close();
    header("Location: borrowed.php");
    exit();
}

// Fetch borrowed books with book info
$sql = "SELECT b.id as borrow_id, bk.title, b.phone, b.email, b.department, b.borrow_date
        FROM borrowed_books b
        JOIN books bk ON b.book_id = bk.id
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Borrowed Books - Library System</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
.table-wrapper { padding: 50px; }
</style>
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

<div class="container table-wrapper">
    <h2 class="mb-4">My Borrowed Books</h2>
    <table class="table table-bordered table-striped bg-white shadow-sm">
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Borrow Date</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td>
                        <a href="borrowed.php?delete=<?php echo $row['borrow_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No borrowed books found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
