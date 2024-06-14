$(document).ready(function () {
    $("#message-success").fadeIn("slow");

    setTimeout(function () {
        $("#message-success").fadeOut("slow", function () {
            $(this).removeClass("error").addClass("hidden");
        });
    }, 3000);
});
