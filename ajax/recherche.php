<?php
$conn = new mysqli("localhost", "root", "", "dataware7");
if ($conn->connect_error) {
    die("connection failed : " . $connection->connect_error);
}

$filterByDate = isset($_GET['filterByDate']) ? $_GET['filterByDate'] : 'asc';

$searchTitle = isset($_GET['searchTitle']) ? $_GET['searchTitle'] : '';

// Vérifiez s'il y a des résultats
if ($result->num_rows > 0) {

    $questions = array();

    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    echo json_encode($questions);
} else {
    echo json_encode(array('message' => 'Aucun résultat trouvé.'));
}

$conn->close();
?>






<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Fonction pour charger les questions en utilisant AJAX
        function loadQuestions(searchTitle) {
            $.ajax({
                type: "GET",
                url: "question.php",
                data: {
                    searchTitle: searchTitle
                },
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

        // Gestionnaire d'événement pour la recherche par titre
        $("#searchTitle").on("input", function() {
            var searchValue = $(this).val();
            var filterValue = $("#filterByDate").val();
            loadQuestions(filterValue, searchValue);
        });
    });
</script>