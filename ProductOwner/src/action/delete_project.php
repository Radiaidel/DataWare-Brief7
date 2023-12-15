<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["project_id"])) {
    // Get the project ID from the POST request
    $projectId = $_POST["project_id"];

    // Delete the project from the database
    $query = "DELETE FROM projects WHERE id = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        // Bind the project ID parameter
        $stmt->bind_param("i", $projectId);

        // Execute the delete statement
        $stmt->execute();
        $stmt->close();

        // Redirect to the projects page or show a success message
        header("Location: /data/product_owner/src/index.php");
        exit();
    } else {
        // Handle the error
        echo "Error: " . $con->error;
    }
}

// Close the database connection
$con->close();
?>

