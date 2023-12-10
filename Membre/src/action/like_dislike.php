<?php
session_start();
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $answer_id = $_POST["answer_id"];
    $action = $_POST["action"];
    $user_id = $_SESSION["id"];

    // Update the database based on the action (like or dislike)
    if ($action == "like") {
        // Implement logic to increment the likes count in the database
        // Example: $conn->query("UPDATE answer SET likes = likes + 1 WHERE answer_id = $answer_id");
    } elseif ($action == "dislike") {
        // Implement logic to increment the dislikes count in the database
        // Example: $conn->query("UPDATE answer SET dislikes = dislikes + 1 WHERE answer_id = $answer_id");
    }

    // Redirect back to the page displaying answers
    header("Location: response.php");
    exit();
}
?>
