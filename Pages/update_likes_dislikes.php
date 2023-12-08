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
            // Fetch the updated like or dislike count
            $selectSql = "SELECT likes, dislikes FROM question WHERE question_id = $questionId";
            $selectResult = $conn->query($selectSql);

            if ($selectResult->num_rows > 0) {
                $row = $selectResult->fetch_assoc();

                // Create an associative array for the JSON response
                $response = array('likes' => $row['likes'], 'dislikes' => $row['dislikes']);
                // Encode the array to JSON and echo the response
                echo json_encode($response);
            } else {
                // If no record is found, return an empty JSON object
                echo json_encode(array('likes' => 0, 'dislikes' => 0));
            }
        } else {
            // If the update failed, return an error message in JSON format
            echo json_encode(array('error' => "Error updating $updateField count in the database"));
        }
    } else {
        // If the action is invalid, return an error message in JSON format
        echo json_encode(array('error' => "Invalid action"));
    }
} else {
    // If the request method is not POST, return an error message in JSON format
    echo json_encode(array('error' => "Invalid request method"));
}

// Close the database connection
$conn->close();
