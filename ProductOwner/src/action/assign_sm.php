<?php
// Include your database connection file and fetch user data
require_once "../../../includes/config/connection.php";

// Fetch user data from the database
$query = "SELECT * FROM users WHERE role != 'po'";
$result = mysqli_query($conn, $query);
?>

<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- <script src="../../js/main.js" defer></script> -->
    <title>Product Owner</title>
    <style>
        .bg-F12D2D {
        background-color: #F12D2D;
    }
    </style>
</head>
<body>
<!-- In your header.php or any appropriate template file -->
<header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo or Branding -->
            <div class="text-xl font-bold w-32 mt-1">
                <img src="../../../img/logov.PNG" class="w-full h-auto" alt="Logo">
            </div>

            <!-- Navigation Links -->
            <nav class="space-x-4">
                <a href="../index.php" class="hover:text-gray-300">Home</a>
                <a href="..//index.php" class="hover:text-gray-300">Projects</a>
                <a href="../actions/assign_sm.php" class="hover:text-gray-300">Assign Scrum Master</a>
                <!-- Add more links as needed -->
            </nav>

            <!-- User Information -->
            <div class="flex items-center">
                <span class="mr-2">Product Owner</span>
                <a href="../../../logout.php" class="hover:text-gray-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-6 h-6 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </header>
<div class="container mx-auto mt-8">
    <h1 class="text-center text-2xl font-semibold mb-4">List of Members :</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php
        // Loop through the user data and display information for each user
        while ($userData = mysqli_fetch_assoc($result)) {
            // Construct the image path (if it already includes "upload/", no need to add it again)
           
            $imagePath = htmlspecialchars("/DataWare-Brief7/" . $userData['image_url']);
            ?>
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                <div class="flex flex-col items-center py-6">
                    <?php
                    // Debugging line to print the image path
                    // var_dump($imagePath);
                    ?>
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
                        <form action="./change_role.php" method="post">
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

</body>

</html>
