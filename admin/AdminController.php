<?php
class AdminController
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function displayUserAccounts()
    {
        echo "<h2>User Accounts</h2>";
        echo "<form method='GET'>";
        echo "<input type='hidden' name='action' value='users'>";
        echo "<label for='search'>Search by Username: </label>";
        echo "<input type='text' id='search' name='search' placeholder='Enter username'>";
        echo "<button type='submit'>Search</button>";
        echo "</form>";

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th>Password</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $sql = "SELECT user_id, username, email, is_active, password FROM Users";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $this->conn->real_escape_string($_GET['search']);
            $sql .= " WHERE username LIKE '%$search%'";
        }

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>" . ($row['is_active'] ? 'Active' : 'Suspended') . "</td>";
                echo "<td>";
                echo "<input type='password' value='{$row['password']}' id='password_{$row['user_id']}' disabled>"; // Password field with ID for dynamic toggle
                echo "<input type='checkbox' onchange='togglePassword({$row['user_id']})'> Show Password"; // Checkbox for toggle
                echo "</td>";
                echo "<td>";
                echo "<a href='edit_user.php?id={$row['user_id']}'>Edit</a> | ";
                if ($row['is_active']) {
                    echo "<a href='suspend_unsuspend_user.php?id={$row['user_id']}&action=suspend'>Suspend</a>";
                } else {
                    echo "<a href='suspend_unsuspend_user.php?id={$row['user_id']}&action=unsuspend'>Unsuspend</a>";
                }
                echo " | <a href='delete_user.php?id={$row['user_id']}' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    public function displayUserProfiles()
    {
        echo "<h2>User Profiles</h2>";

        echo "<form method='GET'>";
        echo "<input type='hidden' name='action' value='profiles'>";
        echo "<label for='search'>Search by First Name or Last Name: </label>";
        echo "<input type='text' id='search' name='search' placeholder='Enter name'>";
        echo "<button type='submit'>Search</button>";
        echo "</form>";

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Address</th>";
        echo "<th>Profile Picture</th>";
        echo "<th>Bio</th>";
        echo "<th>Status</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $sql = "SELECT u.username, up.user_id, up.first_name, up.last_name, up.address, up.profile_picture, up.bio, u.is_active
        FROM UserProfiles up
        INNER JOIN Users u ON up.user_id = u.user_id";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $this->conn->real_escape_string($_GET['search']);
            $sql .= " WHERE u.username LIKE '%$search%'
              OR up.first_name LIKE '%$search%'
              OR up.last_name LIKE '%$search%'
              OR up.address LIKE '%$search%'
              OR up.profile_picture LIKE '%$search%'
              OR up.bio LIKE '%$search%'
              OR u.is_active LIKE '%$search%'";
        }

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['first_name']}</td>";
                echo "<td>{$row['last_name']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['profile_picture']}</td>";
                echo "<td>{$row['bio']}</td>";
                echo "<td>" . ($row['is_active'] ? 'Active' : 'Suspended') . "</td>";
                echo "<td>
                        <a href='edit_profile.php?id={$row['user_id']}'>Edit</a>  
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No user profiles found</td></tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    public function displayUserInteractions()
    {
        // Retrieve all user interactions from the database
        $sql = "SELECT u.username, pi.interaction_type, pl.title, pi.interaction_timestamp
                        FROM PropertyInteractions pi
                        INNER JOIN Users u ON pi.user_id = u.user_id
                        INNER JOIN PropertyListings pl ON pi.listing_id = pl.listing_id";

        // Handle search functionality
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $this->conn->real_escape_string($_GET['search']);
            $sql .= " WHERE u.username LIKE '%$search%' OR pl.title LIKE '%$search%'";
        }

        $sql .= " ORDER BY pi.interaction_timestamp DESC";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['interaction_type']}</td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['interaction_timestamp']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No interactions found</td></tr>";
        }

    }
}
?>