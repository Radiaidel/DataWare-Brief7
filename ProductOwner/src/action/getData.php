<?php
// Include your database connection configuration here
include '../DataWare-Brief7/includes/config/connection.php';

// Get the selected chart type from the URL parameter
$chartType = $_GET['chartType'];

// Fetch data based on the selected chart type
switch ($chartType) {
    // ... (existing cases remain unchanged)

    default:
        // Default to questionsPerProject
        $sql = "SELECT project.project_name, COUNT(question.question_id) AS num_questions 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                GROUP BY project.Id_Project";
        break;
}

$result = $conn->query($sql);

if ($result === false) {
    // Output detailed error message
    die(json_encode(['error' => 'Error executing query: ' . $conn->error]));
}

// Process data for Chart.js
$data = [];
while ($row = $result->fetch_assoc()) {
    $data['labels'][] = $row['project_name'];
    $data['datasets'][0]['data'][] = $row['num_questions'];
    $data['datasets'][0]['backgroundColor'][] = '#3490dc'; // You can customize the colors as needed
}

// Return data as JSON
header('Content-Type: application/json');

// Output data only, without any additional messages
echo json_encode($data);

$conn->close();
?>
