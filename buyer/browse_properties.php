<?php
session_start();
require_once '../dbconnect.php';
require_once '../class_user.php';
require_once 'BuyerController.php';

$buyerController = new BuyerController($conn, $_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_url = $_POST['current_url'];

    if (isset($_POST['save_listing_id'])) {
        $listing_id = $_POST['save_listing_id'];
        $buyerController->SavePropertyListing($listing_id);
        header("Location: $current_url");
        exit();
    }

    if (isset($_POST['remove_save_id'])) {
        $listing_id = $_POST['remove_save_id'];
        $buyerController->removeSavedListing($listing_id);
        header("Location: $current_url");
        exit();
    }
}

// Get the current page number from the query parameter, default to 1 if not set
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Properties - Real Estate System</title>
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
                <li><a href="accounts.php">Account</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <input type="text" id="search" name="search" placeholder="find property type or location">
        <input type="submit" value="Search">
    </form>
       <?php
    $search = isset($_GET['search']) ? $_GET['search'] : null;
    if ($search) {
        $buyerController->searchPropertyListings($search);
    } else {
    }
    ?>

        <!-- Property Listings Section -->
        <?php if (isset($_GET['listing_id'])) {
            echo "<section>";
            $listingID = $_GET['listing_id'];
            $buyerController->DisplayPropertyListing($listingID);
            echo "</section>";
        } else {
            echo "<section>";
            echo "<h2>Property Listings</h2>";
            $buyerController->BrowsePropertyListings($page);
            echo "</section>";
        } ?>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>

</html>

<?php
// Close database connection
$conn->close();
?>