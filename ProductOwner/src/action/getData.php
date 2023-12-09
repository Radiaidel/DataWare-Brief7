<?php
// Include your database connection configuration here

  $conn = new mysqli("localhost", "root", "", "dataware_db");
  if ($conn->connect_error) {
      die("connection failed : " . $connection->connect_error);
  }
  //  UTF-8
mysqli_set_charset($conn, "utf8");


// Rest of your code
$chartType = $_GET['chartType'];

// Fetch data based on the selected chart type
switch ($chartType) {
  

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
