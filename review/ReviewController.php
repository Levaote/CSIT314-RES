<?php
class ReviewController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function displayAllAgentRatings()
    {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Agent Name</th>";
        echo "<th>Email</th>";
        echo "<th>Average Rating</th>";
        echo "<th>View Comments</th>";
        echo "<th>Write Review</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $sql = "SELECT u.user_id, u.username, u.email, AVG(r.rating) AS avg_rating
            FROM Users u
            LEFT JOIN Reviews r ON u.user_id = r.agent_id
            WHERE u.role = 'Real Estate Agent'
            GROUP BY u.user_id, u.username, u.email";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>" . number_format($row['avg_rating'], 1) . "</td>";
                echo "<td><a href='agent_ratings.php?agent_id={$row['user_id']}&agent_name={$row['username']}'>View Comments</a></td>";
                echo "<td><a href='write_review.php?agent_id={$row['user_id']}'>Write Review</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No agents found.</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    
    public function displayAgentComments($agent_id, $agent_name)
    {
        $sql = "SELECT u.username, r.rating, r.comments
            FROM Reviews r
            INNER JOIN Users u ON r.user_id = u.user_id
            WHERE r.agent_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $agent_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<h2>$agent_name's Comments</h2>";
            echo "<table>";
            echo "<thead><tr><th>User</th><th>Rating</th><th>Comment</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['rating']}</td>";
                echo "<td>{$row['comments']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No comments found for this agent.";
        }
        echo '<a href="agent_ratings.php">Back to Agent Ratings</a>';
    }
    
        public function writeReview($user_id, $agent_id, $rating, $comments)
        {
            $insert_review = "INSERT INTO Reviews (user_id, agent_id, rating, comments) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insert_review);
            $stmt->bind_param("iiis", $user_id, $agent_id, $rating, $comments);
    
            if ($stmt->execute()) {
                $interaction_query = "INSERT INTO Interactions (user_id, agent_id, interaction_type) VALUES (?, ?, 'Rate')";
                $this->conn->query($interaction_query);
                header("Location: agent_ratings.php");
                exit();
            } else {
                echo "Error: " . $this->conn->error;
            }
        }
}
?>