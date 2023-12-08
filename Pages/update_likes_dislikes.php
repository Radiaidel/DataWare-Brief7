<?php
include("../includes/config/connection.php");

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the action (like or dislike) and question ID from the request
    $action = $_POST['action'];
    $questionId = $_POST['question_id'];

    // Check if the action is valid (like or dislike)
    if ($action == 'like' || $action == 'dislike') {
        // Update the like or dislike count in the database
        $updateField = ($action == 'like') ? 'likes' : 'dislikes';
        $sql = "UPDATE question SET $updateField = $updateField + 1 WHERE question_id = $questionId";
        $result = $conn->query($sql);

        // Check if the update was successful
        if ($result) {
            // Fetch and return the updated like or dislike count
            $selectSql = "SELECT $updateField FROM question WHERE question_id = $questionId";
            $selectResult = $conn->query($selectSql);

            if ($selectResult->num_rows > 0) {
                $row = $selectResult->fetch_assoc();
                echo $row[$updateField];
            } else {
                echo "0";
            }
        } else {
            echo "Error updating $updateField count in the database";
        }
    } else {
        echo "Invalid action";
    }
} else {
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
