<?php
// Include your database connection configuration here
$conn = new mysqli("localhost", "root", "", "dataware_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8");

$chartType = $_GET['chartType'];

switch ($chartType) {
    case 'questionsPerProject':
        $labelField = 'project_name';
        $sql = "SELECT project.$labelField AS label, COUNT(question.question_id) AS num_questions 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                GROUP BY project.Id_Project";
        break;

    case 'projectsMostQuestions':
        $labelField = 'project_name';
        $sql = "SELECT project.$labelField AS label, COUNT(question.question_id) AS num_questions 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                GROUP BY project.Id_Project
                ORDER BY num_questions DESC
                LIMIT 5";
        break;

    case 'projectLeastAnswers':
        $labelField = 'project_name';
        $sql = "SELECT project.$labelField AS label, COUNT(answer.answer_id) AS num_answers 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                LEFT JOIN answer ON question.question_id = answer.question_id
                GROUP BY project.Id_Project
                ORDER BY num_answers ASC
                LIMIT 1";
        break;

    case 'userMostAnswers':
        $labelField = 'username';
        $sql = "SELECT users.$labelField AS label, COUNT(answer.answer_id) AS num_answers 
                FROM users
                LEFT JOIN answer ON users.id_user = answer.user_id
                GROUP BY users.id_user
                ORDER BY num_answers DESC
                LIMIT 5";
        break;

    default:
        $labelField = 'project_name';
        $sql = "SELECT project.$labelField AS label, COUNT(question.question_id) AS num_questions 
                FROM project
                LEFT JOIN question ON project.Id_Project = question.Id_Project
                GROUP BY project.Id_Project";
        break;
}

$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data['labels'][] = $row['label'];
    $data['datasets'][0]['data'][] = $row['num_answers'] ?? $row['num_questions'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
