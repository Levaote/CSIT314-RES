<?php
session_start();

include '../dbconnect.php';
include 'BuyerController.php';

$buyerController = new BuyerController($conn, $_SESSION['user_id']);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to fetch user information
$user_query = "SELECT * FROM Users WHERE user_id = $user_id";
$user_result = $conn->query($user_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="buyer.css">

</head>

<body>
    <header>
        <h1>Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Buyer'; ?>!
        </h1>
        <nav>
            <ul>
                <li><a href="buyer.php">Home</a></li>
                <li><a href="browse_properties.php">Browse Properties</a></li>
                <li><a href="mortgage_calculator.php">Mortgage Calculator</a></li>
                <li><a href="../review/agent_ratings.php">View Agents</a></li>
                <li><a href="#">Account</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>My Account Information</h2>

        <?php
        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            echo "<p><strong>Username:</strong> {$user['username']}</p>";
            echo "<p><strong>Email:</strong> {$user['email']}</p>";
            echo "<p><strong>Phone:</strong> {$user['phone']}</p>";
        } else {
            echo "<p>No user information found.</p>";
        }
        ?>

        <h2>Transaction History</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php $buyerController->displayTransaction(); ?>
            </tbody>
        </table>
    </main>
</body>

</html>

<?php $conn->close() ?>