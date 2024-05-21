<?php
require_once '../class_user.php'; // Include the User class definition

class BuyerController
{
    protected $conn;
    protected $userID;

    public function __construct($conn, $userID)
    {
        $this->conn = $conn;
        $this->userID = $userID;
    }

    public function SavePropertyListing($listing_id)
    {
        $save_query = "INSERT INTO SavedListings (buyer_id, listing_id) VALUES ($this->userID, $listing_id)";
        if ($this->conn->query($save_query) === TRUE) {
            $update_query = "INSERT INTO PropertyInteractions (user_id, listing_id, interaction_type) VALUES ($this->userID, $listing_id, 'Save')";
            $this->conn->query($update_query);
        } else {
            echo "Error: Listing cannot be saved." . $this->conn->error;
        }
    }

    public function removeSavedListing($listing_id)
    {
        $remove_query = "DELETE FROM SavedListings WHERE buyer_id = $this->userID AND listing_id = $listing_id";
        if ($this->conn->query($remove_query) === TRUE) {
            $delete_query = "DELETE FROM PropertyInteractions WHERE user_id = $this->userID AND listing_id = $listing_id AND interaction_type = 'Save'";
            $this->conn->query($delete_query);
        } else {
            echo "Error: Listing cannot be removed" . $this->conn->error;
        }
    }

    public function BrowsePropertyListings($page = 1, $limit = 10)
    {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Property Type</th>";
        echo "<th>Location</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $offset = ($page - 1) * $limit;
        $listingsQuery = "SELECT * FROM PropertyListings WHERE status = 'Active' LIMIT $limit OFFSET $offset";
        $listingsResult = $this->conn->query($listingsQuery);

        if ($listingsResult->num_rows > 0) {
            while ($row = $listingsResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['property_type']}</td>";
                echo "<td>{$row['location']}</td>";
                echo "<td><a href='browse_properties.php?listing_id={$row['listing_id']}'>View</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No new listings found.</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";

        // Add pagination controls
        $this->displayPaginationControls($page, $limit);
    }

    private function displayPaginationControls($page, $limit)
    {
        $countQuery = "SELECT COUNT(*) AS total FROM PropertyListings WHERE status = 'Active'";
        $countResult = $this->conn->query($countQuery);
        $totalRows = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $limit);

        echo '<nav>';
        echo '<ul class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $page ? 'class="active"' : '';
            echo "<li><a $active href='browse_properties.php?page=$i'>$i</a></li>";
        }
        echo '</ul>';
        echo '</nav>';
    }

    

    public function DisplayPropertyListing($listingID) {
        $propertyQuery = "SELECT * FROM PropertyListings 
                          JOIN Users ON PropertyListings.agent_id = Users.user_id 
                          JOIN UserProfiles ON Users.user_id = UserProfiles.user_id
                          WHERE listing_id = $listingID";
    
        $propertyResult = $this->conn->query($propertyQuery);
        if ($propertyResult->num_rows > 0) {
            $property = $propertyResult->fetch_assoc();
            echo "<h2>{$property['title']}</h2>";
            echo "<p>{$property['description']}</p><br>";
            echo "<p><strong>Property Type:</strong> {$property['property_type']}</p>";
            echo "<p><strong>Location:</strong> {$property['location']}</p>";
            echo "<p><strong>Price:</strong> $" . number_format($property['price'], 2) . "</p>";
            echo "<a href='mortgage_calculator.php?calc={$property['price']}'>Calculate Loan</a><br><br>";
            echo "<p><strong>Agent:</strong> {$property['first_name']} {$property['last_name']}</p>";
            echo "<p><strong>Email:</strong> {$property['email']}</p>";
            echo "<p><strong>Phone:</strong> {$property['phone']}</p>";
    
            $current_url = $_SERVER['REQUEST_URI'];
    
            if ($this->checkSave($listingID)) {
                echo "
                <form method='POST' action=''>
                    <input type='hidden' name='remove_save_id' value='{$property['listing_id']}'>
                    <input type='hidden' name='current_url' value='$current_url'>
                    <button type='submit'>Remove from Saved</button>
                </form>
                ";
            } else {
                echo "
                <form method='POST' action=''>
                    <input type='hidden' name='save_listing_id' value='{$property['listing_id']}'>
                    <input type='hidden' name='current_url' value='$current_url'>
                    <button type='submit'>Save Listing</button>
                </form>
                ";
            }
    
        } else {
            echo "<p>Property listing not found.</p>";
        }
    
        // Add view count to PropertyInteractions
        $view_query = "INSERT INTO PropertyInteractions (user_id, listing_id, interaction_type) VALUES ($this->userID, $listingID, 'View')";
        $this->conn->query($view_query);
    
        // Count views in PropertyInteractions
        $view_query = "SELECT COUNT(*) AS view_count FROM PropertyInteractions WHERE listing_id = $listingID AND interaction_type = 'View'";
        $view_result = $this->conn->query($view_query);
        $view_count = $view_result->fetch_assoc()['view_count'];
    
        // Display view count
        echo "<p><strong>Views:</strong> $view_count</p><br><br>";
        echo "<a href='browse_properties.php'>Back to Listings</a>";
    }

    public function checkSave($listing_id)
    {
        $check_query = "SELECT save_id FROM SavedListings WHERE buyer_id = $this->userID AND listing_id = $listing_id";
        $check_result = $this->conn->query($check_query);
        if ($check_result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function displaySavedListing()
    {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Description</th>";
        echo "<th>Property Type</th>";
        echo "<th>Price</th>";
        echo "<th>Location</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $savedQuery = "SELECT p.*, s.save_id FROM PropertyListings p
                        JOIN SavedListings s ON p.listing_id = s.listing_id
                        WHERE s.buyer_id = $this->userID";
        $savedResult = $this->conn->query($savedQuery);

        if ($savedResult->num_rows > 0) {
            while ($row = $savedResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "<td>{$row['property_type']}</td>";
                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                echo "<td>{$row['location']}</td>";
                echo "<td><a href='buyer.php?remove_save_id={$row['save_id']}'>Remove from Saved</a><br>
                        <a href='browse_properties.php?listing_id={$row['listing_id']}'>View</a><br>
                        <a href='mortgage_calculator.php?calc={$row['price']}'>Calculate Loan</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No saved listings found.</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    public function displayTransaction()
    {
        $transaction_query = "SELECT * FROM Transactions WHERE user_id = $this->userID ORDER BY transaction_date DESC";
        $transaction_result = $this->conn->query($transaction_query);
        if ($transaction_result->num_rows > 0) {
            while ($row = $transaction_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['transaction_id']}</td>";
                echo "<td>{$row['amount']}</td>";
                echo "<td>{$row['transaction_date']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No transactions found.</td></tr>";
        }        
    }
    public function searchPropertyListings($search) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM PropertyListings WHERE property_type LIKE '%$search%' OR location LIKE '%$search%'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while($property = $result->fetch_assoc()) {
                // Display property listing
                echo "<h2>{$property['title']}</h2>";
                echo "<p>{$property['description']}</p><br>";
                echo "<p><strong>Property Type:</strong> {$property['property_type']}</p>";
                echo "<p><strong>Location:</strong> {$property['location']}</p>";
                echo "<p><strong>Price:</strong> $" . number_format($property['price'], 2) . "</p>";
            }
        } else {
            echo "<p>No property listings found.</p>";
        }
    }
}
?>