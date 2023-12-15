<?php
// Include your database connection file
require_once "../../../includes/config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $projectId = isset($_POST["Id_Project"]) ? $_POST["Id_Project"] : null;
    $name = isset($_POST["name"]) ? $_POST["name"] : null;
    $description = isset($_POST["description"]) ? $_POST["description"] : null;
    $startDate = isset($_POST["start_date"]) ? $_POST["start_date"] : null;
    $endDate = isset($_POST["end_date"]) ? $_POST["end_date"] : null;
    $status = $_POST["status"];
   

      // If the status is not set, use the default value from the form (text input)
      if ($status === null) {
         $status = isset($_POST["project_status"]) ? $_POST["project_status"] : null;
      }

    $scrumMasterId = isset($_POST["scrum_master"]) ? $_POST["scrum_master"] : null;

    // Update project data in the database
    $query = "UPDATE project SET 
               project_name = ?,
               project_description = ?,
               created_at = ?, -- Adjust the column name if needed
               deadline = ?,
               project_status = ?,
               id_user = ?
             WHERE Id_Project = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Adjust the number of 's' and 'i' in the bind_param based on the number and types of parameters
        $stmt->bind_param("ssssiii", $name, $description, $startDate, $endDate, $status, $scrumMasterId, $projectId);
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
?>
