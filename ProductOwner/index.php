<?php
// Include your database connection file
require_once "../includes/config/connection.php"; 

// Fetch project data from the database
$projectQuery = "SELECT project.*, users.username AS scrum_master_name 
                 FROM project 
                 JOIN users ON project.id_user = users.id_user";
$projectResult = mysqli_query($conn, $projectQuery);

// Fetch user data from the database
$userQuery = "SELECT * FROM users WHERE role != 'po'";
$userResult = mysqli_query($conn, $userQuery);
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

<body class="bg-gray-200">
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
                <a href="./src/action/static.php"
                    class="text-white hover:text-gray-300 transition duration-300">Statics</a>
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
            <a href="./src/action/static.php"
                class="text-white hover:text-gray-300 transition duration-300">Statics</a>
            <a href="../logout.php" class="text-white hover:text-gray-300 transition duration-300">Log out</a>
        </nav>
    </div>

    <div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-center text-2xl font-semibold flex-grow">List of Projects :</h1>
        <button class="bg-ce0033 text-white font-semibold py-2 px-4 rounded-full" onclick="redirectToCreateProject()">Add Project</button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
            <?php
            // Loop through the project data and display information for each project
            while ($row = mysqli_fetch_assoc($projectResult)) {
            ?>
                <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full">
                    <!-- Project -->
                    <div>
                        <h2 class="text-xl font-semibold text-center mb-2"><?php echo $row['project_name']; ?></h2>
                        <p class="text-gray-700 text-center mb-2">
                            <span class="font-semibold">Scrum Master:</span> <?php echo $row['scrum_master_name']; ?>
                        </p>
                        <p class="text-gray-600 mb-4"><?php echo $row['project_description']; ?></p>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <span class="bg-blue-100 border border-blue-500 text-blue-500 px-3 py-1 rounded-full text-xs"><?php echo $row['project_status']; ?></span>
                        <span class="bg-green-100 border border-green-500 text-green-500 px-3 py-1 rounded-full text-xs">
                            <?php echo date('d M Y', strtotime($row['deadline'])); ?>
                        </span>
                    </div>

                    <div class="flex justify-center mt-4">
                        <button type="button" class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="editProject(<?php echo $row['Id_Project']; ?>)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 17V21H7L17.59 10.41L13.17 6L3 16.17V17ZM21.41 5.59L18.83 3L20.41 1.41C20.59 1.23 20.8 1.09 21 1.03C21.2 0.97 21.41 0.99 21.59 1.07L23.59 3.07C23.77 3.15 23.91 3.36 23.97 3.57C24.03 3.78 24.01 3.99 23.93 4.17L22.34 6.76L21.41 5.59Z" fill="currentColor"/>
                            </svg>
                        </button>

                        <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="confirmDelete(<?php echo $row['Id_Project']; ?>)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 6L5 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5 6L19 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="container mx-auto mt-8">
        <h1 class="text-center text-2xl font-semibold mb-4">List of Members :</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php
            // Loop through the user data and display information for each user
            while ($userData = mysqli_fetch_assoc($userResult)) {
                $imagePath = htmlspecialchars("/DataWare-Brief7/" . $userData['image_url']);
            ?>
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    <div class="flex flex-col items-center py-6">
                        <!-- Your existing user card code goes here -->
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="<?php echo $imagePath; ?>" alt="User Image">
                        <h5 class="mb-1 text-xl font-medium text-gray-900"><?php echo htmlspecialchars($userData['username']); ?></h5>
                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($userData['email']); ?></span>
                        
                        <!-- Display the role with a badge or label -->
                        <?php
                        $roleBadgeStyle = ($userData['role'] === 'sm') ? 'background-color: #FF5733;' : 'background-color: #808080;';
                        ?>
                        <span class="inline-block px-2 py-1 text-xs font-semibold text-white" style="<?php echo $roleBadgeStyle; ?> rounded-full mt-2">
                            Role: <?php echo ucfirst($userData['role']); ?>
                        </span>
                        <!-- Add more fields as needed -->

                        <div class="flex mt-4">
                            <!-- Add a form to change the user's role -->
                            <form action="./src/action/change_role.php" method="post">
                                <input type="hidden" name="id_user" value="<?php echo $userData['id_user']; ?>">
                                <select name="new_role" class="mr-2 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                                    <option value="user">User</option>
                                    <option value="sm">Scrum Master</option>
                                </select>
                                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Change Role
                                </button>
                            </form>
                        </div>
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
        document.getElementById('burgerBtn').addEventListener('click', function () {
            document.getElementById('burgerOverlay').classList.toggle('hidden');
        });

        function toggleDropdown(index) {
            var dropdown = document.getElementById('dropdown-' + index);
            dropdown.classList.toggle('hidden');
        }

        function redirectToCreateProject() {
            // Redirect to the Create Project page
            window.location.href = './src/action/create_project.php';
        }

        function editProject(projectId) {
            // Redirect to the Edit Project page with the project ID
            window.location.href = `./src/action/update_project.php?Id_Project=${projectId}`;
        }

        function confirmDelete(projectId) {
            // Display a confirmation dialog
            if (confirm("Are you sure you want to delete this project?")) {
                // If the user confirms, submit a form to delete the project
                deleteProject(projectId);
            } else {
                // If the user cancels, do nothing or provide feedback
                console.log("Deletion canceled.");
            }
        }

        function deleteProject(projectId) {
            // Create a form element dynamically
            var form = document.createElement("form");
            form.method = "post";
            form.action = "./src/action/delete_project.php"; // Corrected action for deletion

            // Create an input element for the project ID
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "project_id";
            input.value = projectId;

            // Append the input element to the form
            form.appendChild(input);

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>
