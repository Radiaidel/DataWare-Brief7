<?php
// Include your database connection file
require_once "../../../includes/config/connection.php"; 


// Check if the project ID is provided in the URL
if (isset($_GET['Id_Project'])) {
    $projectId = isset($_GET['Id_Project']) ? trim($_GET['Id_Project']) : null;

    // Fetch project data from the database for the specified ID
    $query = "SELECT * FROM project WHERE Id_Project = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();
    $projectData = $result->fetch_assoc();
    $stmt->close();

    // Fetch the name of the Scrum Master for the selected project
    $scrumMasterQuery = "SELECT u.username FROM users u WHERE u.id_user = ?";
    $stmt = $conn->prepare($scrumMasterQuery);
    $stmt->bind_param("i", $projectData['scrum_master_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $scrumMasterData = $result->fetch_assoc();
    $stmt->close();

    // Format dates to match HTML5 date input format (YYYY-MM-DD)
    $projectData['created_at'] = date('Y-m-d', strtotime($projectData['created_at']));
    $projectData['deadline'] = date('Y-m-d', strtotime($projectData['deadline']));

    // Fetch a list of Scrum Masters
    $scrumMastersQuery = "SELECT id_user, username FROM users WHERE role = 'sm'";
    $scrumMastersResult = $conn->query($scrumMastersQuery);
    $scrumMasters = [];
    while ($row = $scrumMastersResult->fetch_assoc()) {
        $scrumMasters[] = $row;
    }
} else {
    // Handle error if project ID is not provided
    echo "Error: Project ID not provided.";
    exit();
}
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
                <a href="../../index.php" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
                <a href="./community.php"
                    class="text-white hover:text-gray-300 transition duration-300">Community</a>
                    <a href="./static.php"
                    class="text-white hover:text-gray-300 transition duration-300">Statics</a>    
                <button id="logoutBtn" class="text-white px-7 py-2 rounded-full border border-white">
                    <a href="../logout.php" class="text-white">Log Out</a>
                </button>
            </nav>
        </div>
    </header>
<div class="container mx-auto mt-10">
    <h1 class="text-center text-2xl font-semibold mb-4">Edit Project: <?php echo $projectData['project_name']; ?></h1>

    <form action="./processupdate_project.php" method="POST" class="max-w-md mx-auto bg-white p-8 border rounded-md shadow-md">

        <!-- Add form fields with existing project data -->
        <input type="hidden" name="Id_Project" value="<?php echo $projectId; ?>">

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Project Name:</label>
            <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['project_name']; ?>" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
            <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required><?php echo $projectData['project_description']; ?></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['created_at']; ?>" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['deadline']; ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
            <input type="text" id="status" name="status" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['project_status']; ?>" required>
        </div>
        <div class="mb-4">
            <label for="scrum_master" class="block text-sm font-medium text-gray-700">Scrum Master:</label>
            <select id="scrum_master" name="scrum_master" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                <?php foreach ($scrumMasters as $scrumMaster): ?>
                    <option value="<?php echo $scrumMaster['id_user']; ?>" <?php echo ($scrumMaster['id_user'] == $projectData['scrum_master_id']) ? 'selected' : ''; ?>>
                        <?php echo $scrumMaster['username']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Add other form fields based on your table structure -->

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Save Changes</button>
    </form>
</div>


<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('Form Data:', new FormData(this));
        this.submit(); // If everything is correct, submit the form
    });
</script>
