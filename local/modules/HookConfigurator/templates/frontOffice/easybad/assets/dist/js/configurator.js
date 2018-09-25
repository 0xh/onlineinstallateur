$(document).ready(function () {
    $(".choice-image").click(function () {
        $(this).children("p").children("input:checkbox").click();

        if ($(this).children("p").children("input:checkbox").prop('checked')) {
            $(this).addClass("selected");
        } else {
            $(this).removeClass("selected");
        }
    });

    var current_progress = 1, previous_progress = 1, current_step, next_step, previous_step, steps;
    steps = $("fieldset").length;

    $(".simpleNext").click(function () {
        if (current_progress < steps) {
            current_step = $(this).parent().parent().parent().parent();
            previous_step = current_step;
            next_step = $(this).parent().parent().parent().parent().next();
            next_step.show();
            current_step.hide();
            previous_progress = current_progress;
            setProgressBar(++current_progress);
        }
    });

    $(".next").click(function () {
        if (current_progress < steps) {
            current_step = $(this).parent().parent().parent().parent().parent();
            previous_step = current_step;
            //console.log(previous_step);
            var next_question = $(this).attr("next-question");
            previous_progress = current_progress;
            if (typeof next_question != "undefined" && next_question != "")
            {
                current_progress = next_question;
                next_question = +next_question + 1;
                var child = $(this).parent().parent().parent().parent().parent().parent().children().get(next_question);
                next_step = $(child);
            } else {
                next_step = $(this).parent().parent().parent().parent().parent().next();
                current_progress = +current_progress + 1;
            }

            next_step.show();
            current_step.hide();
            setProgressBar(current_progress);
        }
    });
    $(".previous").click(function () {
        current_step = $(this).parent();
        if (previous_step != null) {
            next_step = previous_step;
            previous_step = null;
        } else {
            next_step = $(this).parent().prev();
            previous_progress -= 1;
        }

        next_step.show();
        current_step.hide();
        current_progress = previous_progress;
        setProgressBar(current_progress);
    });

    $('.frage .frontIcons').not(".frontIcons-multiple").on('click', function (e) {
        $(this).parent().children().removeClass("selected");
        /*if ($('input:radio', this).prop('checked') === true) {
         console.log("returning false");
         return false;
         }*/
        $('input:radio', this).prop('checked', true);
        $(this).addClass("selected");
    });


    setProgressBar(current_progress);
    // Change progress bar action
    function setProgressBar(curStep) {
        var percent = 2 + parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
                .css("width", percent + "%")
                .html(' Frage ' + current_progress + '/' + $(".multistepForm fieldset").length + '&nbsp;&nbsp;&nbsp;');
    }

    Dropzone.options.registrationForm = {

        // Prevents Dropzone from uploading dropped files immediately
        autoProcessQueue: false,
        uploadMultiple: true,
        addRemoveLinks: true,
        parallelUploads: 10,
        maxFilesize: 256,
        clickable: true,
        previewsContainer: '#previews',
        hiddenInputContainer: "#imsirun",
        capture: "#imsirun",
        dictDefaultMessage: "Drop files here to upload",
        dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
        dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
        dictFileTooBig: "File is too big ( { { filesize } } MiB). Max filesize: { { maxFilesize } } MiB.",
        dictInvalidFileType: "You can't upload files of this type.",
        dictResponseError: "Server responded with { { statusCode } } code.",
        dictCancelUpload: "Cancel upload",
        dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
        dictRemoveFile: "Entfernen",
        dictRemoveFileConfirmation: null,
        dictMaxFilesExceeded: "You can not upload any more files.",

        init: function () {

            var submitButton = document.getElementById("push_configurator_data");
            myDropzone = this; // closure

            submitButton.addEventListener("click", function (e) {

                if (myDropzone.files.length != 0) {
                    e.preventDefault();
                    myDropzone.processQueue();
                }

            });
        },
        success: function (file, response) {
            document.open();
            document.write(response);
            document.close();
        }
    };

    Dropzone.autoDiscover = false;
    if($("#dropzonePreview").size() > 0)
    $("#registration-form").dropzone();
});