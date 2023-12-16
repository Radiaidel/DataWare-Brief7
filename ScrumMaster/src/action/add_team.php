<?php
include("../../../includes/config/connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_team'])) {
    $teamName = htmlspecialchars($_POST['team_name']);
    $idProjet = intval($_POST["projet"]);

    // Validate inputs here (e.g., check if teamName is not empty)

    $insertTeamQuery = "INSERT INTO team (team_name, created_at, id_user, Id_Project) VALUES (?, NOW(), ?, ?)";
    $stmt = $conn->prepare($insertTeamQuery);

    if ($stmt) {
        $stmt->bind_param("sii", $teamName, $user, $idProjet);

        if ($stmt->execute()) {
            $idEquipe = $stmt->insert_id;

            $sqlInsertMembres = "INSERT INTO in_team (id_user, Id_Team) VALUES (?, ?)";
            $requeteInsertMembres = $conn->prepare($sqlInsertMembres);

            foreach ($_POST['membresEquipe'] as $idMembre) {
                // Validate $idMembre here

                $requeteInsertMembres->bind_param("ii", $idMembre, $idEquipe);
                $requeteInsertMembres->execute();
            }

            echo "<p class='text-green-500 text-center'>Team created successfully!</p>";
            header("Location: ../../index.php");
        } else {
            echo "<p class='text-red-500 text-center'>Error creating team: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='text-red-500 text-center'>Error preparing team creation: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<!-- ... (rest of your HTML code) ... -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Create Team</title>
</head>

<body class="bg-gray-200 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Create Team</h2>

        <form method="post" class="space-y-4">
            <div>
                <label for="team_name" class="block text-sm font-medium text-gray-700">Team Name:</label>
                <input type="text" id="team_name" name="team_name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="projet" class="block text-gray-700 text-sm font-bold mb-2">Projet de l'Équipe</label>
                <select id="projet" name="projet"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                    <?php
                    $sqlProjet = "SELECT Id_Project, project_name FROM project where id_user =?";
                    $requeteProjet = $conn->prepare($sqlProjet);
                    $requeteProjet->bind_param("i", $user);
                    $requeteProjet->execute();
                    $resultatProjet = $requeteProjet->get_result();
                    while ($rowProjet = $resultatProjet->fetch_assoc()) {
                        echo "<option value=\"{$rowProjet['Id_Project']}\">{$rowProjet['project_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="membresEquipe" class="block text-gray-700 text-sm font-bold mb-2">Membres de
                    l'Équipe</label>
                <select id="membresEquipe" name="membresEquipe[]" multiple class="w-full px-1 py-2 border rounded">
                    <?php
                    $sqlMembres = "SELECT id_user, email FROM users WHERE role='user'";
                    $requeteMembres = $conn->prepare($sqlMembres);
                    $requeteMembres->execute();
                    $resultatMembres = $requeteMembres->get_result();
                    while ($rowMembre = $resultatMembres->fetch_assoc()) {
                        echo "<option value=\"{$rowMembre['id_user']}\">{$rowMembre['email']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="create_team"
                class="w-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">Create
                Team</button>


        </form>
    </div>

</body>

</html>

<?php

// Close the database connection
$conn->close();
?>