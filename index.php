<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            $email = $_POST['email'];
            $motDePasse = $_POST['password'];

            $requete = $conn->prepare("SELECT * FROM users WHERE email = ?");
            if (!$requete) {
                die("Erreur de préparation de la requête : " . $conn->error);
            }

            $requete->bind_param("s", $email);
            $requete->execute();
            $resultat = $requete->get_result();

            if ($utilisateur = $resultat->fetch_assoc()) {

                if (password_verify($motDePasse, $utilisateur['pass_word'])) {
                    session_start();
                    $_SESSION['id'] =$utilisateur['id_user'];
                    if ($utilisateur['role'] == 'user') {
                        header("Location: ./Membre/src/index.php");
                        exit();
                    } elseif ($utilisateur['role'] == 'po') {
                        header("Location:  ./ProductOwner/src/index.php");
                        exit();
                    } else {
                        header("Location:  ./ScrumMaster/src/index.php");
                        exit();
                    }
                } else {
                    echo "Mot de passe incorrect.";
                }
            } else {
                echo "Aucun utilisateur trouvé avec cet email.";
            }

            $requete->close();
        }

        ?>
        <form name="signInForm" action="index.php" method="POST" onsubmit="return validateForm();">
            <!--Email input-->
            <div class="mb-4">
                <input type="email" id="email" name="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg"
                    required>
            </div>
            <!--Password input-->
            <div class="mb-6">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-red-500 text-white py-2 rounded-2xl hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Get
                started</button>
            <p class="mt-4 text-gray-600 text-xs text-center">Don't have an account? <a href="./SignUp.php"
                    class="text-blue-500 hover:underline">Sign up here</a>.</p>
        </form>

    </div>

</body>

</html>