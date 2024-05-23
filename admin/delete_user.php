<?php
include '../dbconnect.php';

$user_id = $_GET['id'];

$sql = "DELETE FROM Users WHERE user_id=$user_id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully";
    // Redirect to admin page in 3 seconds
    echo "<br>Redirecting in 3 seconds...";
    header("refresh:3;url=admin.php");
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>
