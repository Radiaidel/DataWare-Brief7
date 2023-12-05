<?php
require_once "./includes/config.php"; // Adjust the path as needed

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    // Default image path
    $img = "default.jpg";

    // Check if the image was uploaded
    if ($_FILES['profilePicture']['name']) {
        $targetDirectory = "upload/";
        $targetPath = $targetDirectory . basename($_FILES['profilePicture']['name']);
        
        // Create the "upload" directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        
        // Now move the uploaded file
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
            // File uploaded successfully
            echo "The file " . basename($_FILES['profilePicture']['name']) . " has been uploaded.";
            $img = "upload/" . $_FILES['profilePicture']['name'];
        } else {
            // Error uploading file
            echo "Sorry, there was a problem uploading your file.";
        }
    }

    // Insert user data into the database
    $query = "INSERT INTO users (username, password, email, image_url, role) VALUES (?, ?, ?, ?, 'user')";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssss", $username, $password, $email, $img);
        $stmt->execute();
        $stmt->close();
        
        // Registration successful, you can redirect the user to another page if needed
        header("Location: index.php");
        exit();
    } else {
        // Registration failed, handle the error
        echo "Error: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Add Tailwind CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <title> Registration Form</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Sign Up</h2>

        <form action="SignUp.php" method="POST" enctype="multipart/form-data">
          <div class="mt-4">
            <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" class="mt-1 p-2 w-full border rounded-md">
          </div>
          <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" class="mt-1 p-2 w-full border rounded-md">
          </div>
          <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 p-2 w-full border rounded-md">
          </div>
          <div class="mt-4">
            <label for="profilePicture" class="block text-sm font-medium text-gray-600">Choose Profile Picture</label>
            <input type="file" id="profilePicture" name="profilePicture" accept="image/*" class="mt-1 p-2 w-full border rounded-md">
          </div>
          <div class="mt-6">
            <input type="checkbox" id="acceptTerms" name="acceptTerms" class="border border-gray-400">
            <label for="acceptTerms" class="ml-2 text-sm text-gray-600">I accept the <a href="#" class="text-purple-500 font-semibold">Terms of Use</a> & <a href="#" class="text-purple-500 font-semibold">Privacy Policy</a></label>
          </div>
          <div class="mt-6">
            <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-2xl hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Register Now</button>
          </div>
        </form>
      </div>
</body>
</html>
