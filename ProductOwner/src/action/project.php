<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Page</title>
    <script src="../Javascript/script.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-GLhlTQ8iN17SJLlFfZVfP5z01K4JPTNqDQ5a6jgl5Up3H+9TP5IotK2+Obr4u" crossorigin="anonymous" />

        <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
    </head>

<body class="bg-gray-200 ">

    <?php
    include("../../../includes/config/connection.php");
    include '../../template/header.php';
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location:../../../logout.php ");
    }    $userId = $_SESSION['id'];
    $sql = "
    SELECT DISTINCT p.*,DATEDIFF(p.deadline, CURDATE()) AS days_remaining ,u.username as scrum_master
    FROM project p
    Join users u on u.id_user = p.id_user
    JOIN team t ON p.Id_Project = t.Id_Project
    JOIN in_team it ON t.Id_Team = it.Id_Team
    WHERE it.id_user = ?
";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $result = $stmt->get_result();

    echo "<div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 px-12 mt-10 mx-auto\">";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>

            <form action="question_project.php" method="post">
                <input hidden type="text" name="id_project" value="<?php echo $row['Id_Project']; ?>">
                <button type="submit" name="submitproject"  class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full"  >
                        <h2 class="text-xl font-semibold text-center mb-2">
                            <?php echo $row['project_name']; ?>
                        </h2>
                        <p class="text-gray-700 text-center mb-2"><span class="font-semibold">Scrum Master:</span> <?php echo $row['scrum_master']; ?></p>
                        <p class="text-gray-600 mb-4">
                            <?php echo $row['project_description']; ?>
                        </p>
                        <div class="flex justify-between">
                        <span class="bg-blue-100 border border-blue-500 text-blue-500 px-5 py-2 rounded-full">
                            <?php echo $row['project_status']; ?>
                        </span>
                        <span class="flex-shrink-0 mx-8"></span>
                        <span class="bg-red-100 border border-red-500 text-red-500 px-3 py-2 rounded-full">
                            <?php echo $row['days_remaining']; ?> restants
                        </span>
                    </div>
                                    
                </button>

            </form>
            <?php
        }
    } else {
        echo "Aucun projet trouvé.";
    }

    echo "</div>";
    $stmt->close();
    ?>
</body>

</html>