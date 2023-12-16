<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Update Team</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Update Team</h2>

        <?php
        // Include your database connection file
        include("../../../includes/config/connection.php");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['id'];

        // Check if the team ID is provided in the URL
        if (isset($_GET['id'])) {
            $teamId = $_GET['id'];

            // Fetch team data from the database
            $query = "SELECT team.* ,project.project_name as project_name FROM team, project WHERE Id_Team = $teamId and team.Id_Project=project.Id_Project";
            $result = mysqli_query($conn, $query);

            // Check if the team exists
            if ($row = mysqli_fetch_assoc($result)) {
                $teamName = $row['team_name'];
                $project_name = $row['project_name'];
                $id_project = $row['Id_Project'];



                $sqlMembers = "SELECT id_user FROM in_team WHERE Id_Team = ?";
                $requeteMembers = $conn->prepare($sqlMembers);
                $requeteMembers->bind_param("i", $teamId);
                $requeteMembers->execute();
                $resultMembers = $requeteMembers->get_result();

                // Store team member IDs in an array
                $membresEquipe = [];
                while ($rowMember = $resultMembers->fetch_assoc()) {
                    $membresEquipe[] = $rowMember['id_user'];
                }




                // Process form submission for updating team details
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $newTeamName = $_POST['team_name'];
                    $idProjet = htmlspecialchars($_POST["projet"]);
                    $membresEquipe = $_POST["membresEquipe"];
                    // Update team details in the database
                    $updateQuery = "UPDATE team SET team_name = '$newTeamName' ,Id_Project=$idProjet  WHERE Id_Team = $teamId";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($updateResult) {

                        // Delete existing team members from MembreEquipe table
                        $sqlDeleteMembers = "DELETE FROM in_team WHERE Id_Team = ?";
                        $stmtDeleteMembers = $conn->prepare($sqlDeleteMembers);
                        $stmtDeleteMembers->bind_param("i", $teamId);
                        $stmtDeleteMembers->execute();

                        // Insert updated team members into MembreEquipe table
                        $sqlInsertMembres = "INSERT INTO in_team (id_user, Id_Team) VALUES (?, ?)";
                        $requeteInsertMembres = $conn->prepare($sqlInsertMembres);

                        foreach ($membresEquipe as $idMembre) {
                            $requeteInsertMembres->bind_param("ii", $idMembre, $teamId);
                            $requeteInsertMembres->execute();
                        }


                        echo "<p class='text-green-500'>Team details updated successfully!</p>";
                        header("Location: ../../index.php");
                    } else {
                        echo "<p class='text-red-500'>Error updating team details: " . mysqli_error($conn) . "</p>";
                    }
                }
            } else {
                echo "<p class='text-red-500'>Team not found!</p>";
            }
        } else {
            echo "<p class='text-red-500'>Team ID not provided in the URL.</p>";
        }
        ?>

        <form method="post" class="space-y-4">
            <div>
                <label for="team_name" class="block text-sm font-medium text-gray-700">Team Name:</label>
                <input type="text" id="team_name" name="team_name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500"
                    value="<?php echo $teamName; ?>" required>
            </div>

            <div class="mb-4">
                <label for="projet" class="block text-gray-700 text-sm font-bold mb-2">Projet de l'Équipe</label>
                <select id="projet" name="projet"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">

                    <?php
                    $sqlProjet = "SELECT Id_Project, project_name FROM project WHERE id_user = ?";
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
            <button type="submit" name="update_team"
                class="w-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">
                Update
                Team</button>

        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // This script will run after the DOM is fully loaded
            document.getElementById('projet').value = '<?php echo $id_project; ?>';

            const selectMembresEquipe = document.getElementById('membresEquipe');
            const membresEquipe = <?php echo json_encode($membresEquipe); ?>;

            // Set selected property based on the obtained values
            for (let i = 0; i < selectMembresEquipe.options.length; i++) {
                if (membresEquipe.includes(parseInt(selectMembresEquipe.options[i].value))) {
                    selectMembresEquipe.options[i].selected = true;
                }
            }
        });
    </script>
</body>

</html>