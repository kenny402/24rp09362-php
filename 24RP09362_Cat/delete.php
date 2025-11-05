<?php
include 'db.php';

// Delete if 'delete' parameter exists
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']); // sanitize input
    $stmt = $conn->prepare("DELETE FROM borrowed_books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: borrowed.php?msg=deleted");
    exit();
}
?>
