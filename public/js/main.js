$(document).ready(function() {

    $("#login_form").submit(function(event) {
        $.post('/login', $(this).serialize(), function(json) {
            if (json.success === true) {
                location.reload(true);
            } else {
                $("#error").html(json.error);
            }
        }, "json");
        event.preventDefault();
    });

});