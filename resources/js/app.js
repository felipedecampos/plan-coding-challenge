require('./bootstrap');

// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
    $(this).on('submit',function(e){
        let $form = $(this);

        if ($form.data('submitted') === true) {
            // Previously submitted - don't submit again
            e.preventDefault();
        } else {
            // Mark it so that the next submit can be ignored
            $form.data('submitted', true);
        }
    });

    return this;
};

$('#tictactoe-play').preventDoubleSubmission();

$(document).on('click', '.tictactoe-play-button', function() {
    $('#position').val($(this).data('position'));

    $('#tictactoe-play').submit();
});
