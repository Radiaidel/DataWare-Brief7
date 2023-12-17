<?php
// Include your database connection file
require_once "../../../includes/config/connection.php";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user ID and new role from the form submission
    $userId = $_POST["id_user"];
    $newRole = $_POST["new_role"];

    // Update the user's role in the database
    $updateQuery = "UPDATE users SET role = '$newRole' WHERE id_user = $userId";
    $updateResult = mysqli_query($conn, $updateQuery);

    // Check if the update was successful
    if ($updateResult) {
        echo "Role updated successfully.";
        header("Location: ../../index.php");
        exit();
    } else {
        echo "Error updating role: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
