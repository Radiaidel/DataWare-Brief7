<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the team ID from the POST data
    $teamId = $_POST["team_id"];

    // Perform the deletion in the database
    $deleteQuery = "DELETE FROM team WHERE Id_Team = $teamId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    // Check if the deletion was successful
    if ($deleteResult) {
        echo "Team deleted successfully!";
        header("Location: ../../index.php");
    } else {
        echo "Error deleting team: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If the request is not a POST request, redirect to an error page or the team list page
    header("Location: ../error.php");
    exit();
}
?>
