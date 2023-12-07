<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CDN du Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
     <!--CDN du JS -->
    <script src="./js/main.js" defer></script>
    <title>Sign In</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Sign In</h2>
        <?php
        // Include configuration and connect to the database
        require_once "./includes/config/connection.php";
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Query to check user credentials
            $query = "SELECT pass_word, role FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($hashedPassword, $role);
                $stmt->fetch();
                $stmt->close();
                // Verify password
                // die("password :".$password . " hashed password". $hashedPassword);
                if (password_verify($password, $hashedPassword)) {
                    // Assuming $role is the role retrieved from the database
                    if ($role === 'scrum_master') {
                        header("Location: ./Scrum_Master/src/index.php");
                        exit();
                    } elseif ($role === 'product_owner') {
                        header("Location: ./product_owner/src/index.php");
                        exit();
                    } elseif ($role === 'user') {
                        header("Location: ./Membre/src/index.php");
                        exit();
                    } else {
                        //unknown role dispalay a page error 
                        header("Location: generic_dashboard.php");
                        exit();
                    }
                    echo "<p class='text-green-500 text-center'>Login successful! Welcome, $username!</p>";
                } else {
                    // Incorrect password
                    echo "<p class='text-red-500 text-center'>Incorrect email or password.</p>";
                }
            } else {
                // Handle database connection error
                echo "<p class='text-red-500 text-center'>Error: " . $conn->error . "</p>";
            }
        }
        ?>
        <form name="signInForm" action="index.php" method="POST" onsubmit="return validateForm();">   
            <!--Email input-->    
            <div class="mb-4">  
                <input type="email" id="email" name="email" placeholder="Email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg" required>
            </div>
            <!--Password input-->   
            <div class="mb-6">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg" required>
            </div>

            <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-2xl hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Get started</button>
            <p class="mt-4 text-gray-600 text-xs text-center">Don't have an account? <a href="./SignUp.php" class="text-blue-500 hover:underline">Sign up here</a>.</p>
        </form>

    </div>

</body>
</html>
