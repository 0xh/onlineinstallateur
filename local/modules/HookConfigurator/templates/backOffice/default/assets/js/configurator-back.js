$(document).ready(function () {

    $('.getDataIcon').click(function () {
        $("#div_data_icon_" + $(this).attr("data-id")).attr("data-icon", $(this).attr("data-icon"));
        $("#div_data_icon_" + $(this).attr("data-id")).attr("data-value", $(this).attr("data-value"));
        $("#data_icon_" + $(this).attr("data-id")).val($(this).attr("data-value"));
        modal.style.display = "none";
    });

    $('.myBtn').click(function () {
        modal.style.display = "block";
        $('.getDataIcon').attr("data-id", $(this).attr("data-id"));
    });

    $('.close').click(function () {
        modal.style.display = "none";
    });

// Get the modal
    var modal = document.getElementById('myModal-hook-configurator');

// Get the button that opens the modal
    var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});