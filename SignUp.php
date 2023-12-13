<?php
require_once "./includes/config/connection.php"; 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    // Hash the password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
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
    $query = "INSERT INTO users (username, pass_word , status, email, image_url, role) VALUES (?, ?, 'active',?, ?, 'user')";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssss", $username, $password, $email, $img);
        $stmt->execute();
        $stmt->close();
        
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database nnection
    $conn->close();
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
  <style >

  .bg-image{
    background:url(./Images/bg.png);
  }      

  </style>
</head>
<body class="bg-image h-screen flex items-center justify-center ">
  

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Sign Up</h2>

        <form action="SignUp.php" method="POST" enctype="multipart/form-data">
          <div class="mt-4">
            
            <input type="text" id="username" name="username" placeholder="Enter your username" class="mt-1 p-2 w-full border rounded-md">
          </div>
          <div class="mt-4">
            
            <input type="email" id="email" name="email" placeholder="Enter your email" class="mt-1 p-2 w-full border rounded-md">
          </div>
          <div class="mt-4">
            
            <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 p-2 w-full border rounded-md">
          </div>

          <div class="mt-4">
            
            <input type="file" id="profilePicture" name="profilePicture" accept="image/*" class="mt-1 p-2 w-full border rounded-md">
          </div>

          
          <div class="mt-6">
           
            <!-- <label for="acceptTerms" class="ml-2 text-sm text-gray-600">I accept the <a href="#" class="text-purple-500 font-semibold">Terms of Use</a> & <a href="#" class="text-purple-500 font-semibold">Privacy Policy</a> -->
            <p class="mt-4 text-gray-600 text-xs text-center">Already have an account ?<a href="index.php"
                    class="text-blue-500 hover:underline"> Sign in here </a>.</p>
          </div>
          <div class="mt-6">
            <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-2xl hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300   ease-linear ">Register Now</button>
          </div>
        </form>
      </div>
</body>
</html>
