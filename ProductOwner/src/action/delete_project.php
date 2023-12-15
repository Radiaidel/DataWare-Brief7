<?php
// Include your database connection file
require_once "../../../includes/config/connection.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["project_id"])) {
    // Get the project ID from the POST request
    $projectId = $_POST["project_id"];

    // Delete the project from the database
    $query = "DELETE FROM project WHERE Id_Project= ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind the project ID parameter
        $stmt->bind_param("i", $projectId);

        // Execute the delete statement
        $stmt->execute();
        $stmt->close();

        // Redirect to the projects page or show a success message
        header("Location: ./index.php");
        exit();
    } else {
        // Handle the error
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

