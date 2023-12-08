<?php
include("../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the deletion
    $questionID = $_POST['questionID'];

    // Perform the deletion in the database, e.g., using a DELETE SQL query
    $deleteQuery = "DELETE FROM question WHERE question_id = $questionID";
    $conn->query($deleteQuery);

    // Redirect back to the questions page
    header("Location: question.php");
    exit();
}
