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
    INNER JOIN users u ON q.user_id = u.id_user WHERE q.Id_Project = ? and q.archived=0";

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

    $sqlInsertQuestion = "INSERT INTO question (user_id, Id_Project, question_text, title_question) VALUES (?, ?, ?, ?)";
    $stmtInsertQuestion = $conn->prepare($sqlInsertQuestion);

    if ($stmtInsertQuestion === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtInsertQuestion->bind_param("iiss", $userID, $projectID, $questionContent, $questionTitle);
    $stmtInsertQuestion->execute();

    $newQuestionID = $stmtInsertQuestion->insert_id;

    $stmtInsertQuestion->close();

    $tagIDs = explode(" ", $tags);

    $sqlInsertQuestionTag = "INSERT INTO question_tag (id_question, id_tag) VALUES (?, ?)";
    $stmtInsertQuestionTag = $conn->prepare($sqlInsertQuestionTag);

    if ($stmtInsertQuestionTag === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtInsertQuestionTag->bind_param("ii", $newQuestionID, $tagID);

    foreach ($tagIDs as $tagID) {
        $tagID = intval($tagID);
        $stmtInsertQuestionTag->execute();
    }

    $stmtInsertQuestionTag->close();
    header("Location: project.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
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
                    <span class="bg-blue-100 border border-blue-500 text-blue-500 px-5 py-2 rounded-md">
                        <?php echo $projectStatus; ?>
                    </span>
                    <span class="bg-red-100 border border-red-500 text-red-500 px-3 py-2 rounded-md">
                        <?php echo $daysRemaining; ?> restants
                    </span>
                </div>
            </div>


            <div class=" w-full bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl text-center font-semibold mb-4">Poser une Question</h2>

                <form action="question_project.php" method="POST">
                    <input type="text" hidden name="idprojet" value=" <?php echo $projectId; ?>">
                    <div class="mb-4">

                        <input type="text" name="question_title" id="question_title" placeholder="Titre de la Question"
                            class="mt-1 p-2 w-full border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <textarea name="question_content" id="question_content" rows="2"
                            placeholder="Contenu de la Question" class="mt-1 p-2 w-full border rounded-md"
                            required></textarea>
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

                    <button name="askQuestion" type="submit" class="bg-red-500 text-white p-2 rounded-md ">Poser la
                        Question</button>
                </form>
            </div>

            <div class="rounded-lg mt-4 ">
                <!-- <h3>Questions liées au projet :</h3> -->
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
                    <div class="mx-auto w-full  bg-gray-100 p-8 rounded-xl shadow-xl text-white mb-4">
                        <div class="flex items-center justify-between text-black mb-4">
                            <div class="flex">

                                <div class="flex-shrink-0">
                                    <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                                </div>
                                <div class="ml-2">
                                    <p class="text-sm text-black">
                                        <?php echo $username; ?>
                                    </p>
                                    <p class="text-xs text-black">
                                        <?php echo $insertionDate; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex  ">
                                <ul role="list" class="flex justify-center space-x-5">
                                    <?php
                                    // Check if the logged-in user is the creator of the question
                                    if ($userID == $row['user_id']) {
                                        ?>
                                        <li>
                                            <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>"
                                                class="text-indigo-300 hover:text-indigo-500 pr-3">


                                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                                        stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                                        stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </a>

                                        </li>
                                        <li>

                                            <a href="deletequestion.php?DeleteID=<?php echo $id_question; ?>"
                                                class="text-indigo-300 hover:text-indigo-500">
                                                <svg width="25px" height="25px" viewBox="0 0 1024 1024" fill="#000000"
                                                    class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M32 241.6c-11.2 0-20-8.8-20-20s8.8-20 20-20l940 1.6c11.2 0 20 8.8 20 20s-8.8 20-20 20L32 241.6zM186.4 282.4c0-11.2 8.8-20 20-20s20 8.8 20 20v688.8l585.6-6.4V289.6c0-11.2 8.8-20 20-20s20 8.8 20 20v716.8l-666.4 7.2V282.4z"
                                                        fill="" />
                                                    <path
                                                        d="M682.4 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM367.2 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM524.8 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM655.2 213.6v-48.8c0-17.6-14.4-32-32-32H418.4c-18.4 0-32 14.4-32 32.8V208h-40v-42.4c0-40 32.8-72.8 72.8-72.8H624c40 0 72.8 32.8 72.8 72.8v48.8h-41.6z"
                                                        fill="" />
                                                </svg>

                                            </a>
                                        </li>


                                        <?php
                                    }
                                    ?>
                                </ul>


                            </div>
                        </div>

                        <div class="mb-6">
                            <h1 class="text-red-600 text-2xl font-bold ">
                                <?php echo $questionTitre; ?>
                            </h1>
                            <br>
                            <p class="text-black">
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
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#000000">

                                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                                stroke="#646066" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>

                                    </svg>
                                    <span class="ml-1">
                                        <?php echo $row['likes']; ?>
                                    </span>
                                </button>

                                <button class="flex items-center text-gray-300 hover:text-red-500">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" transform="rotate(180)">

                                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                                stroke="#646066" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>

                                    </svg>

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

            var selectedTagIds = [];

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

                    selectedTagIds.push(selectedTagId);

                    var updatedTags = currentTags + "" + event.target.value;

                    tagsInput.value = updatedTags.trim();

                    selectedTagIdInput.value = selectedTagIds.join(" ");

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