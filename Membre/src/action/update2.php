<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["answer_id"], $_POST["answer_text"])) {
    $answerId = $_POST["answer_id"];
    $newAnswerText = $_POST["answer_text"];

    // Perform the update in the database (replace 'your_table_name' with your actual table name)
    $updateQuery = "UPDATE answer SET answer_text = '$newAnswerText' WHERE user_id = $answerId";
    $result = $conn->query($updateQuery);

    if ($result) {
        echo "Answer updated successfully";
        header("location:test_delete.php");
    } else {
        echo "Error updating answer: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
