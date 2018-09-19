document.addEventListener('DOMContentLoaded', function() {
    $('.clear_feature_value').click(function (event) {
        $('#feature_value_' + $(this).data('id') + ' option').prop('selected', false);

        event.preventDefault();
    });
}, false);