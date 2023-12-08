<?php
// Include your database connection configuration here
include '../DataWare-Brief7/includes/config/connection.php';

// Get the selected chart type from the URL parameter
$chartType = $_GET['chartType'];

// Fetch data based on the selected chart type
switch ($chartType) {
    case 'questionsPerProject':
        // Example: Fetch number of questions per project
        $sql = "SELECT project.project_name, COUNT(question.question_id) AS num_questions 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                GROUP BY project.Id_Project";
        break;

    case 'projectsMostQuestions':
        // Example: Fetch projects with the most questions
        $sql = "SELECT project.project_name, COUNT(question.question_id) AS num_questions 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                GROUP BY project.Id_Project
                ORDER BY num_questions DESC
                LIMIT 5"; // Limit to the top 5 projects
        break;

    case 'projectLeastAnswers':
        // Example: Fetch project with the fewest answers
        $sql = "SELECT project.project_name, COUNT(answer.answer_id) AS num_answers 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                LEFT JOIN answer ON question.question_id = answer.question_id
                GROUP BY project.Id_Project
                ORDER BY num_answers ASC
                LIMIT 1"; // Limit to the project with the fewest answers
        break;

    case 'userMostAnswers':
        // Example: Fetch user with the most answers
        $sql = "SELECT users.username, COUNT(answer.answer_id) AS num_answers 
                FROM users
                LEFT JOIN answer ON users.id_user = answer.user_id
                GROUP BY users.id_user
                ORDER BY num_answers DESC
                LIMIT 5"; // Limit to the top 5 users
        break;

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
    die("Error executing query: " . $conn->error);
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

// Debugging output - uncomment the following line to see the raw data
// echo json_encode($data);

// Uncomment the following line to see the formatted JSON
// echo json_encode($data, JSON_PRETTY_PRINT);

echo json_encode($data);

$conn->close();
?>
