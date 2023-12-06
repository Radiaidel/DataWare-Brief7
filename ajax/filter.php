<?php
// ... (votre code pour la connexion à la base de données)

// Récupérez la valeur du filtre par date (asc ou desc)
$filterByDate = isset($_GET['filterByDate']) ? $_GET['filterByDate'] : 'asc';

// Requête SQL pour sélectionner les questions triées par date
$sql = "SELECT * FROM question ORDER BY created_at $filterByDate";

// Exécutez la requête
$result = $conn->query($sql);

// Vérifiez s'il y a des résultats
if ($result->num_rows > 0) {
    // Créez un tableau associatif pour stocker les données
    $questions = array();

    // Parcourez les résultats et ajoutez-les au tableau
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    // Renvoyez les données au format JSON
    echo json_encode($questions);
} else {
    echo json_encode(array('message' => 'Aucun résultat trouvé.'));
}

// Fermez la connexion à la base de données
$conn->close();
?>







<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    // Fonction pour charger les questions en utilisant AJAX
    function loadQuestions(filterByDate) {
        $.ajax({
            type: "GET",
            url: "votre_fichier_php.php",
            data: { filterByDate: filterByDate },
            dataType: "json",
            success: function(data) {
                // Effacez le contenu précédent
                $("#questions-container").empty();

                // Parcourez les questions et ajoutez-les au conteneur
                $.each(data, function(index, question) {
                    $("#questions-container").append(
                        "<div>" +
                        "Question ID: " + question.question_id + "<br>" +
                        "User ID: " + question.user_id + "<br>" +
                        "ID Project: " + question.Id_Project + "<br>" +
                        "Question Text: " + question.question_text + "<br>" +
                        "Likes: " + question.likes + "<br>" +
                        "Dislikes: " + question.dislikes + "<br>" +
                        "Created At: " + question.created_at + "<br>" +
                        "Archived: " + question.archived + "<br>" +
                        "<hr>" +
                        "</div>"
                    );
                });
            },
            error: function(error) {
                console.log("Erreur AJAX: " + JSON.stringify(error));
            }
        });
    }

    // Chargement initial des questions (par date ancienne)
    loadQuestions('asc');

    // Gestionnaire d'événement pour le changement de filtre
    $("#filterByDate").change(function() {
        var filterValue = $(this).val();
        loadQuestions(filterValue);
    });
});
</script>
