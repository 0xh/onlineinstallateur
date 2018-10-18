$(document).ready(function () {
    $(".checkbox-box").click(function () {
        console.log($(this).text());
        window.history.pushState("object or string", "Title", "?criteria=true&features=1_(3)&category_id=33&limit=18&page=1&order=manual");
    });

});