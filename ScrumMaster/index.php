<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:../logout.php ");
}
// Include your database connection file
include_once("..\includes\config\connection.php");

// Fetch team data from the database
$query = "SELECT team.*, users.username AS scrum_master_name FROM team JOIN users ON team.id_user = users.id_user";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>dataware | DashBoard</title>
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>

<body class=" bg-gray-200">
    <header class="bg-ce0033 sticky top-0 w-full  p-4 flex justify-between items-center ">
        <div class="text-xl font-bold w-32 mt-1">
            <img src="http://localhost/DataWare-Brief7/Membre/image/logov.PNG" class="w-full h-auto" alt="Logo">
        </div>

        <div class="flex items-center">

            <button id="burgerBtn" class="sm:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <nav class="space-x-4 hidden sm:flex items-center">
                <a href="" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
                <a href="./src/action/community.php"
                    class="text-white hover:text-gray-300 transition duration-300">Community</a>
                    <a href="./src/action/project.php"  class="text-white hover:text-gray-300 transition duration-300">Project</a>

                <button id="logoutBtn" class="text-white px-7 py-2 rounded-full border border-white">
                    <a href="../logout.php" class="text-white">Log Out</a>
                </button>
            </nav>
        </div>
    </header>

    <!-- Navbar Responsive -->
    <div id="burgerOverlay"
        class="fixed py-5 top-18 right-0 w-1/2 h-screen bg-gray-800 bg-opacity-50 z-50 hidden items-center justify-center sm:hidden">
        <nav class="flex flex-col items-center space-y-5">
            <a href="" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
            <a href="./src/action/community.php"
                class="text-white hover:text-gray-300 transition duration-300">Community</a>
                <a href="./src/action/project.php"  class="text-white hover:text-gray-300 transition duration-300">Project</a>

            <a href="../logout.php" class="text-white hover:text-gray-300 transition duration-300">Log out</a>
        </nav>
    </div>

    <script>
        document.getElementById('burgerBtn').addEventListener('click', function () {
            document.getElementById('burgerOverlay').classList.toggle('hidden');
        });


    </script>
    <div class="mt-6">
        <button class="bg-ce0033  text-white font-semibold py-2 px-4 mr-20 rounded-full float-right"
            onclick="redirectToCreateTeam()">Add Team</button>
    </div>




    <div class="container mx-auto mt-12">

        <h1 class="text-2xl font-semibold text-center mb-6">List of Teams:</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 px-4 md:px-8">
            <?php
            // Loop through the team data and display information for each team
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full">
                    <!-- Team -->
                    <div>
                        <h2 class="text-xl font-semibold text-center mb-2">
                            <?php echo $row['team_name']; ?>
                        </h2>
                        <p class="text-gray-700 text-center mb-2">
                        <span class="font-semibold">Scrum Master:</span>
                                                    <?php echo $row['scrum_master_name']; ?>
                        </p>
                    </div>

                    <!-- Display Team Members -->

                    <div>
                        <h3 class="text-lg font-semibold mb-2">Team Members:</h3>
                        <ul class="flex space-x-4">
                            <?php
                            // Fetch team members for the current team
                            $teamId = $row['Id_Team'];
                            $membersQuery = "SELECT users.id_user AS user_id, users.username, users.image_url FROM users
                                            INNER JOIN in_team ON users.id_user = in_team.id_user
                                            WHERE in_team.Id_Team =  $teamId";
                            $membersResult = mysqli_query($conn, $membersQuery);

                            while ($member = mysqli_fetch_assoc($membersResult)) {
                                $profileImage = $member['image_url'] ? $member['image_url'] : 'default_image.jpg';
                                echo "<li>";
                                echo "<img src='/dataware-brief7/{$profileImage}' alt='{$member['username']}' class='w-10 h-10 rounded-full object-cover'>";
                                // Add a button for deleting this team member
                                echo "</li>";
                            }

                            // Close the team members result set
                            mysqli_free_result($membersResult);
                            ?>
                        </ul>
                    </div>
                    <br>

                    <!-- Display Team Projects -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Team Projects:</h3>
                        <ul class="mb-5">
                            <?php
                            // Fetch projects for the current team
                            $projectsQuery = "SELECT * FROM project join team on team.id_project= project.id_project where id_team = $teamId";
                            $projectsResult = mysqli_query($conn, $projectsQuery);

                            while ($project = mysqli_fetch_assoc($projectsResult)) {
                                echo "<li>{$project['project_name']} - {$project['project_description']}</li>";
                            }

                            // Close the projects result set
                            mysqli_free_result($projectsResult);
                            ?>
                        </ul>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="bg-green-100 border border-green-500 text-green-500 px-3 py-1 rounded-full text-xs">
                            <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                        </span>
                    </div>

                    <!-- Button to Add Team Member -->
                    <!-- <div class="flex justify-center mt-4">
                        <button type="button"
                            class="w-50 text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5"
                            onclick="addTeamMember(<?php echo $row['Id_Team']; ?>)">
                            Add Team Member
                        </button>
                    </div> -->
                    <div class="flex justify-center mt-4">
                        <button type="button"
                            class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            onclick="editTeam(<?php echo $row['Id_Team']; ?>)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 17V21H7L17.59 10.41L13.17 6L3 16.17V17ZM21.41 5.59L18.83 3L20.41 1.41C20.59 1.23 20.8 1.09 21 1.03C21.2 0.97 21.41 0.99 21.59 1.07L23.59 3.07C23.77 3.15 23.91 3.36 23.97 3.57C24.03 3.78 24.01 3.99 23.93 4.17L22.34 6.76L21.41 5.59Z"
                                    fill="currentColor" />
                            </svg>
                        </button>

                        <button type="button"
                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                            onclick="confirmDelete(<?php echo $row['Id_Team']; ?>)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 6L5 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5 6L19 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <?php
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>

    </div>


    <script>
        function editTeam(teamId) {
            // Redirect to the Edit Team page with the team ID
            window.location.href = `./src/action/update_team.php?id=${teamId}`;
        }

        function confirmDelete(teamId) {
            // Display a confirmation dialog
            if (confirm("Are you sure you want to delete this team?")) {
                // If the user confirms, submit a form to delete the team
                deleteTeam(teamId);
            } else {
                // If the user cancels, do nothing or provide feedback
                console.log("Deletion canceled.");
            }
        }

        function deleteTeam(teamId) {
            // Create a form element dynamically
            var form = document.createElement("form");
            form.method = "post";
            form.action = "./src/action/delete_team.php";

            // Create an input element for the team ID
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "team_id";
            input.value = teamId;

            // Append the input element to the form
            form.appendChild(input);

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }

        function redirectToCreateTeam() {
            // Redirect to the Create Team page
            window.location.href = './src/action/add_team.php';
        }

        function addTeamMember(teamId) {
            // Redirect to the Add Team Member page with the team ID
            window.location.href = `./src/action/add_members.php?team_id=${teamId}`;
        }

        function deleteTeamMember(teamId, userId) {
            if (confirm("Are you sure you want to delete this team member?")) {
                deleteTeamMemberRequest(teamId, userId);
            } else {
                console.log("Deletion canceled.");
            }
        }

        function deleteTeamMemberRequest(teamId, userId) {
            window.location.href = `./src/action/delete_team_member.php?team_id=${teamId}&user_id=${userId}`;
        }
    </script>

</body>

</html>