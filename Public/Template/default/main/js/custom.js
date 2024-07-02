$(document).ready(function () {
    // Hiện thông báo trong vòng 3 giây
    $("#message-success").fadeIn("slow");

    setTimeout(function () {
        $("#message-success").fadeOut("slow", function () {
            $(this).removeClass("error").addClass("hidden");
        });
    }, 3000);

    // Active Menu
    const urlParams = new URLSearchParams(window.location.search);
    const controller = urlParams.get("controller") ? urlParams.get("controller") : "index";
    const action = urlParams.get("action") ? urlParams.get("action") : "index";
    var controllerAction = controller + "-" + action;
    $("#menu ul li." + controllerAction).addClass("selected");
});

// Submit Pagination
function changePage(page) {
    $("input[name=filter_pagination]").val(page);
    $("#adminForm").submit();
}
