<?php
session_start();

include '../dbconnect.php';
include 'ReviewController.php';

$ReviewController = new ReviewController($conn);

$role = strtolower($_SESSION['role']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agent_id'], $_POST['rating'], $_POST['comments'])) {
        $user_id = $_SESSION['user_id'];
        $agent_id = $_POST['agent_id'];
        $rating = $_POST['rating'];
        $comments = $_POST['comments'];

        $ReviewController->writeReview($user_id, $agent_id, $rating, $comments);

    } else {
        echo "Incomplete form data";
    }
}

if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];

    $agent_query = "SELECT username FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($agent_query);
    $stmt->bind_param("i", $agent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $agent = $result->fetch_assoc();
        $agent_username = $agent['username'];
    } else {
        $agent_username = "Unknown";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review</title>
    <link rel="stylesheet" href="../<?php echo $role; ?>/<?php echo $role; ?>.css">
</head>

<body>
<header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!
        </h1>
        <?php if ($role == 'buyer') { ?>
        <nav>
            <ul>
                <li><a href="../buyer/buyer.php">Home</a></li>
                <li><a href="../buyer/browse_properties.php">Browse Properties</a></li>
                <li><a href="../buyer/mortgage_calculator.php">Mortgage Calculator</a></li>
                <li><a href="agent_ratings.php">Agent Ratings & Reviews</a></li>
                <li><a href="../buyer/accounts.php">Account</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
        <?php } elseif ($role == 'seller') { ?>
        <nav>
            <ul>
                <li><a href="../seller/seller.php">My Property Listings</a></li>
                <li><a href="#.php">Rate Agents</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
        <?php } ?>
    </header>

    <main>
        <a href="agent_ratings.php">Back to Agent Ratings</a>
        <h2>Write Review for Agent:
            <?php echo isset($agent_username) ? htmlspecialchars($agent_username) : 'Unknown'; ?>
        </h2>

        <form method="post">
            <input type="hidden" name="agent_id" value="<?php echo isset($agent_id) ? $agent_id : ''; ?>">

            <label for="rating">Rating (1-5):</label>
            <select id="rating" name="rating" required>
                <option value="">Select Rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" rows="4" required></textarea><br>

            <button type="submit">Submit Review</button>
        </form>
    </main>
</body>

</html>

<?php
$conn->close();
?>