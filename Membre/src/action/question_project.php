<?php
session_start();
$userID = (isset($_SESSION["id"])) ? $_SESSION['id'] : '';
include("../../../includes/config/connection.php");
include '../../template/header.php';

if (isset($_POST['id_project'])) {
    $projectId = $_POST['id_project'];

    $sqlProject = "SELECT p.*, DATEDIFF(p.deadline, CURDATE()) AS days_remaining,u.username as scrum_master
                   FROM project p
                   Join users u on u.id_user = p.id_user
                   WHERE p.Id_Project = ?";

    $stmtProject = $conn->prepare($sqlProject);

    if ($stmtProject === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtProject->bind_param("i", $projectId);

    $stmtProject->execute();

    $resultProject = $stmtProject->get_result();

    if ($resultProject->num_rows > 0) {
        $projectData = $resultProject->fetch_assoc();
        $projectName = $projectData['project_name'];
        $scrumMaster = $projectData['scrum_master'];
        $projectDescription = $projectData['project_description'];
        $projectStatus = $projectData['project_status'];
        $daysRemaining = $projectData['days_remaining'];
    } else {
        echo " not found";
    }



    $sqlQuestions = " SELECT q.*, u.image_url, u.username FROM question q 
    INNER JOIN users u ON q.user_id = u.id_user WHERE q.Id_Project = ?";

    $stmtQuestions = $conn->prepare($sqlQuestions);

    if ($stmtQuestions === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtQuestions->bind_param("i", $projectId);

    $stmtQuestions->execute();

    $resultQuestions = $stmtQuestions->get_result();

    $projectQuestions = [];
    if ($resultQuestions->num_rows > 0) {
        while ($question = $resultQuestions->fetch_assoc()) {
            $projectQuestions[] = $question;
        }
    }
} else {
    header("Location:project.php");
}


//equipes
$sqlTeam = "
SELECT t.team_name, GROUP_CONCAT(u.username) AS team_members
FROM team t
JOIN in_team it ON t.Id_Team = it.Id_Team
JOIN users u ON it.id_user = u.id_user
WHERE t.Id_Project = ?
GROUP BY t.Id_Team;";

$stmtTeam = $conn->prepare($sqlTeam);

if ($stmtTeam === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

$stmtTeam->bind_param("i", $projectId);

$stmtTeam->execute();

$resultTeam = $stmtTeam->get_result();
$equipes = [];

if ($resultTeam->num_rows > 0) {
    while ($row = $resultTeam->fetch_assoc()) {
        $equipes[] = $row;
    }
}

if (isset($_POST['askQuestion'])) {
    $userID = $_SESSION['id'];
    $projectID = $_POST['idprojet'];
    $questionTitle = $_POST['question_title'];
    $questionContent = $_POST['question_content'];
    $tags = $_POST['selectedTagId'];

    // ... (validation des données, etc.)

    // Insérer la question dans la table 'question'
    $sqlInsertQuestion = "INSERT INTO question (user_id, Id_Project, question_text, title_question) VALUES (?, ?, ?, ?)";
    $stmtInsertQuestion = $conn->prepare($sqlInsertQuestion);

    if ($stmtInsertQuestion === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtInsertQuestion->bind_param("iiss", $userID, $projectID, $questionContent, $questionTitle);
    $stmtInsertQuestion->execute();

    // Récupérer l'ID de la question nouvellement créée
    $newQuestionID = $stmtInsertQuestion->insert_id;

    $stmtInsertQuestion->close();

    // Insérer les relations entre la question et les tags dans la table 'question_tag'
    $tagIDs = explode(" ", $tags);

    $sqlInsertQuestionTag = "INSERT INTO question_tag (id_question, id_tag) VALUES (?, ?)";
    $stmtInsertQuestionTag = $conn->prepare($sqlInsertQuestionTag);

    if ($stmtInsertQuestionTag === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    foreach ($tagIDs as $tagID) {
        $tagID = intval($tagID);

        $stmtInsertQuestionTag->bind_param("ii", $newQuestionID, $tagID);
        $stmtInsertQuestionTag->execute();
    }

    $stmtInsertQuestionTag->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <title>Projet</title>
</head>

<body class="bg-gray-200 ">

    <div class="flex justify-center items-start space-x-4 p-10">
        <!-- Partie Gauche -->
        <div class="w-full space-y-4">

            <div class="bg-white p-8 rounded-lg shadow-md w-full">
                <h2 class="text-2xl font-semibold mb-4 text-center">
                    Projet:
                    <?php echo $projectName; ?>
                </h2>
                <p class="text-gray-700 text-center mb-4"><span class="font-semibold">Scrum Master:</span>
                    <?php echo $scrumMaster; ?>
                </p>
                <p class="text-gray-700 text-center mb-4"><span class="font-semibold"></span>
                    <?php echo $projectDescription; ?>
                </p>
                <div class="flex justify-between">
                    <span class="bg-blue-100 border border-blue-500 text-blue-500 px-5 py-2 rounded-full">
                        <?php echo $projectStatus; ?>
                    </span>
                    <span class="bg-red-100 border border-red-500 text-red-500 px-3 py-2 rounded-full">
                        <?php echo $daysRemaining; ?> restants
                    </span>
                </div>
            </div>


            <div class=" w-full bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl text-center font-semibold mb-4">Poser une Question</h2>

                <form action="" method="post">
                    <input type="text" hidden name="idprojet" value=" <?php echo $projectId; ?>">
                    <div class="mb-4">

                        <input type="text" name="question_title" id="question_title" placeholder="Titre de la Question"
                            class="mt-1 p-2 w-full border rounded-md">
                    </div>

                    <div class="mb-4">
                        <textarea name="question_content" id="question_content" rows="2"
                            placeholder="Contenu de la Question" class="mt-1 p-2 w-full border rounded-md"></textarea>
                    </div>

                    <div class="mb-4">
                        <input type="text" id="tags" name="tags" placeholder="#Tag"
                            class="mt-1 p-2 w-full border rounded-md" list="tagSuggestionsList" />
                        <div id="tagSuggestions">
                            <datalist id="tagSuggestionsList" class="hidden">
                            </datalist>
                        </div>
                        <input type="hidden" id="selectedTagId" name="selectedTagId" value="">
                    </div>

                    <button name="askQuestion" type="submit" class="bg-blue-500 text-white p-2 rounded-md ">Poser la
                        Question</button>
                </form>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md mt-4 ">
                <h3>Questions liées au projet :</h3>
                <?php
                // Affichez les questions liées au projet
                foreach ($projectQuestions as $row) {
                    $imagePath = htmlspecialchars("/DataWare-Brief7/" . $row['image_url']);
                    $insertionDate = $row['created_at'];
                    $username = $row['username'];
                    $questionTitre = $row['title_question'];
                    $questionText = $row['question_text'];
                    $id_question = $row['question_id'];

                    $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = " . $id_question;
                    $tagsResult = $conn->query($tagsSql);
                    ?>
                    <div class="mx-auto w-full bg-gray-800 p-8 rounded-xl shadow-xl text-white mb-4">
                        <div class="flex items-center text-gray-300 mb-4">
                            <div class="flex-shrink-0">
                                <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                            </div>
                            <div class="ml-2">
                                <p class="text-sm">
                                    <?php echo $username; ?>
                                </p>
                                <p class="text-xs">
                                    <?php echo $insertionDate; ?>
                                </p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h1 class="text-white text-2xl font-bold">
                                <?php echo $questionTitre; ?>
                            </h1>
                            <br>
                            <p class="text-gray-300">
                                <?php echo $questionText; ?>
                            </p>
                        </div>

                        <div class="mb-4 space-x-2">
                            <?php
                            // Your existing code for displaying tags
                            if ($tagsResult->num_rows > 0) {
                                while ($tagRow = $tagsResult->fetch_assoc()) {
                                    ?>
                                    <span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded">
                                        <?php echo '#' . $tagRow['tag_name']; ?>
                                    </span>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="flex space-x-5">

                            <div class="flex items-center space-x-4 mb-4"> <!-- Ajout de la classe mb-4 ici -->
                                <button class="flex items-center text-gray-300 hover:text-blue-500">
                                    <span class="ml-1">
                                        <?php echo $row['likes']; ?>
                                    </span>
                                </button>

                                <button class="flex items-center text-gray-300 hover:text-red-500">
                                    <span class="ml-1">
                                        <?php echo $row['dislikes']; ?>
                                    </span>
                                </button>
                            </div>

                            <form action="response.php" method="POST">
                                <input type="text" hidden name="input_id" value=" <?php echo $id_question; ?> ">
                                <button type="submit" class="flex items-center text-gray-600 hover:text-green-500">
                                    <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                        <title>comment-1</title>
                                        <desc>Created with Sketch Beta.</desc>
                                        <defs>

                                        </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                            sketch:type="MSPage">
                                            <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                transform="translate(-100.000000, -255.000000)" fill="#000000">
                                                <path
                                                    d="M116,281 C114.832,281 113.704,280.864 112.62,280.633 L107.912,283.463 L107.975,278.824 C104.366,276.654 102,273.066 102,269 C102,262.373 108.268,257 116,257 C123.732,257 130,262.373 130,269 C130,275.628 123.732,281 116,281 L116,281 Z M116,255 C107.164,255 100,261.269 100,269 C100,273.419 102.345,277.354 106,279.919 L106,287 L113.009,282.747 C113.979,282.907 114.977,283 116,283 C124.836,283 132,276.732 132,269 C132,261.269 124.836,255 116,255 L116,255 Z"
                                                    id="comment-1" sketch:type="MSShapeGroup">

                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ml-1">Respond</span>
                                </button>
                            </form>
                        </div>

                        <ul role="list" class="flex justify-center space-x-5">
                            <?php
                            // Check if the logged-in user is the creator of the question
                            if ($userID == $row['user_id']) {
                                ?>
                                <li>
                                    <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>"
                                        class="text-indigo-300 hover:text-indigo-500">
                                        <svg class="w-8 h-6" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 640 512">
                                            <!-- Your SVG content here -->
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="deletequestion.php?DeleteID=<?php echo $id_question; ?>"
                                        class="text-indigo-300 hover:text-indigo-500">
                                        <svg class="w-6 h-6 mt-3" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 448 512">
                                            <!-- Your SVG content here -->
                                        </svg>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <!-- Partie Droite -->
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full sticky top-20">
            <h3 class="text-xl font-semibold mb-2">Équipes:</h3>
            <?php
            foreach ($equipes as $equipe) {
                echo '<div class="mb-4">';
                echo '<p class="text-gray-700"><span class="font-semibold">Équipe ' . $equipe['team_name'] . '</p>';

                // Liste des membres de l'équipe
                echo '<ul class="list-disc pl-6">';
                $membres = explode(',', $equipe['team_members']);
                foreach ($membres as $membre) {
                    echo '<li>' . $membre . '</li>';
                }
                echo '</ul>';

                echo '</div>';
            }
            ?>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tagsInput = document.getElementById("tags");
            var tagSuggestions = document.getElementById("tagSuggestions");
            var selectedTagIdInput = document.getElementById("selectedTagId");

            tagsInput.addEventListener("input", function () {
                var input = tagsInput.value;

                if (input.includes("#")) {
                    var prefix = input.split("#").pop();
                    getTagSuggestions(prefix);
                } else {
                    tagSuggestions.innerHTML = "";
                }
            });


            tagSuggestions.addEventListener("click", function (event) {
                if (event.target.tagName === "OPTION") {
                    var selectedTagId = event.target.getAttribute("data-tag-id");
                    var currentTags = tagsInput.value;

                    // Ajouter le tag sélectionné à la liste des tags actuels
                    var updatedTags = currentTags + "" + event.target.value;

                    // Mettre à jour l'input avec les tags sélectionnés
                    tagsInput.value = updatedTags.trim();

                    // Mettre à jour le champ caché avec l'ID du tag sélectionné
                    document.getElementById("selectedTagId").value = selectedTagId;

                    // Vider les suggestions après sélection
                    tagSuggestions.innerHTML = "";
                }
            });


        });

        function getTagSuggestions(prefix) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "tag_suggestions.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("tagSuggestions").innerHTML = xhr.responseText;
                }
            };
            xhr.send("prefix=" + encodeURIComponent(prefix));
        }
    </script>

</body>

</html>