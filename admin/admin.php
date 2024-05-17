<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Real Estate System</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style>
        /* Additional CSS styles can be added here */
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
    </style>
</head>
<body>
    <header>
        <h1>Welcome, System Administrator!</h1>
        <nav>
            <ul>
                <li><a href="admin.php?action=users">User Accounts</a></li>
                <li><a href="admin.php?action=profiles">User Profiles</a></li>
                <li><a href="analytics.php?action=analytics">Analytics</a></li>
                <li><a href="../LogoutController.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        include '../dbconnect.php';
        include 'AdminController.php';

        $adminController = new AdminController($conn);

        $action = isset($_GET['action']) ? $_GET['action'] : 'users';

        if ($action === 'users') {
            $adminController->displayUserAccounts();
        } 
        elseif ($action === 'profiles') {
            $adminController->displayUserProfiles();
        }

        // Close connection
        $conn->close();
        ?>

        <script>
            function togglePassword(userId) {
                const passwordField = document.getElementById(`password_${userId}`);
                const checkbox = document.querySelector(`input[type='checkbox'][onchange='togglePassword(${userId})']`);

                if (checkbox.checked) {
                    passwordField.type = 'text'; 
                } else {
                    passwordField.type = 'password'; 
                }
            }
        </script>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>
</html>
