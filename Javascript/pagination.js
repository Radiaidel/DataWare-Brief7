function loadQuestions(page) {
    $.ajax({
        url: '/DataWare-Brief7/Membre/src/action/load_questions.php',
        type: 'POST',
        data: { page: page },
        success: function (data) {
            $('#pagination-container').html(data);
        },
        error: function () {
            console.log('Error loading questions.');
        }
    });
}

// Load initial questions on page load
$(document).ready(function () {
    loadQuestions(1);
});