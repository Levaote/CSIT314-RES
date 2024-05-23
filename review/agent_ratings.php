<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../dbconnect.php';
include 'ReviewController.php';

$ReviewController = new ReviewController($conn);

$role = strtolower($_SESSION['role']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Ratings & Reviews</title>
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
                <li><a href="agent_ratings.php">View Agents</a></li>
                <li><a href="../buyer/accounts.php">Account</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
        <?php } elseif ($role == 'seller') { ?>
        <nav>
            <ul>
                <li><a href="../seller/seller.php">My Property Listings</a></li>
                <li><a href="agent_ratings.php">View Agents</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
        <?php } ?>
    </header>
    <main>
        
        <?php
        if (!isset($_GET['agent_id'])) {
            echo "<h2>All Agents</h2>";
            $ReviewController->displayAllAgentRatings();
        } elseif (isset($_GET['agent_id'])) {
            $agent_id = $_GET['agent_id'];
            $agent_name = $_GET['agent_name'];
            $ReviewController->displayAgentProfile($agent_id);
            $ReviewController->displayAgentComments($agent_id, $agent_name);
        }
        ?>
    </main>
</body>

</html>

<?php
// Close database connection
$conn->close();
?>