<?php
include '../dbconnect.php';
include 'AdminController.php';
$adminController = new AdminController($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Real Estate System</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type=text] {
            padding: 8px;
        }
        .search-container button {
            padding: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Analytics - User Interactions & Transactions</h1>
        <nav>
            <ul>
                <li><a href="admin.php?action=users">User Accounts</a></li>
                <li><a href="admin.php?action=profiles">User Profiles</a></li>
                <li><a href="analytics.php">Analytics</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="search-container">
            <form method="GET">
                <input type="hidden" name="action" value="analytics">
                <label for="search">Search by Username or Listing Title: </label>
                <input type="text" id="search" name="search" placeholder="Enter keyword">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Interaction Type</th>
                    <th>Listing</th>
                    <th>Interaction Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $adminController->displayUserInteractions();
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>
</html>
