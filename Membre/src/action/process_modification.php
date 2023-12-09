<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the modification
    $questionID = $_POST['questionID'];
    $modifiedText = $_POST['questionText'];

    // Perform the update in the database, e.g., using an UPDATE SQL query
    $updateQuery = "UPDATE question SET question_text = '$modifiedText' WHERE question_id = $questionID";
    $conn->query($updateQuery);

    // Redirect back to the questions page
    header("Location: community.php");
    exit();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
