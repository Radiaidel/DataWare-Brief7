<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the deletion
    if (isset($_POST['confirm_delete'])) {

        $questionID = $_POST['questionID'];

        // Perform the deletion in the database, e.g., using a DELETE SQL query
        $deleteQuery = "DELETE FROM question WHERE question_id = $questionID";
        $conn->query($deleteQuery);

        // Redirect back to the questions page
        header("Location: community.php");
        exit();
    } elseif (isset($_POST['cancel_delete'])) {
        header("Location: community.php");

    }
}
