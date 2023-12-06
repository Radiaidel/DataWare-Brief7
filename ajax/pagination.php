<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Fonction pour charger les questions en utilisant AJAX
        function loadQuestions(filterByDate, searchTitle, page) {
            $.ajax({
                type: "GET",
                url: "questions.php",
                data: {
                    filterByDate: filterByDate,
                    searchTitle: searchTitle,
                    page: page
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

        // Fonction pour charger la pagination en utilisant AJAX
        function loadPagination(filterByDate, searchTitle) {
            $.ajax({
                type: "GET",
                url: ".php",
                data: {
                    filterByDate: filterByDate,
                    searchTitle: searchTitle
                },
                dataType: "json",
                success: function(data) {
                    // Calculez le nombre total de pages
                    var totalPages = Math.ceil(data.length / 10);

                    // Effacez le contenu précédent
                    $("#pagination-container").empty();

                    // Ajoutez des liens de pagination
                    for (var i = 1; i <= totalPages; i++) {
                        $("#pagination-container").append(
                            "<a href='#' class='page-link' data-page='" + i + "'>" + i + "</a>"
                        );
                    }

                    // Ajoutez un gestionnaire d'événement pour les liens de pagination
                    $(".page-link").click(function() {
                        var page = $(this).data("page");
                        loadQuestions(filterByDate, searchTitle, page);
                    });
                },
                error: function(error) {
                    console.log("Erreur AJAX: " + JSON.stringify(error));
                }
            });
        }

        // Chargement initial des questions et de la pagination (par date ancienne)
        loadQuestions('asc', '', 1);
        loadPagination('asc', '');

        // Gestionnaire d'événement pour le changement de filtre
        $("#filterByDate").change(function() {
            var filterValue = $(this).val();
            var searchValue = $("#searchTitle").val();
            loadQuestions(filterValue, searchValue, 1);
            loadPagination(filterValue, searchValue);
        });

        // Gestionnaire d'événement pour la recherche par titre
        $("#searchTitle").on("input", function() {
            var searchValue = $(this).val();
            var filterValue = $("#filterByDate").val();
            loadQuestions(filterValue, searchValue, 1);
            loadPagination(filterValue, searchValue);
        });
    });
</script>