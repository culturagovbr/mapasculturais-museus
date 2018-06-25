$(document).ready(function() {
    var modal_el = 'select[name="mus_EnCorrespondencia_mesmo"]';
    if ($(modal_el).length > 0) {
        var _toggable = '.entity-modal .en-correspondencia';
        $(_toggable).hide().removeAttr('required').css('margin-left', 20);
        $(modal_el).change( function() {
            var _answer = $(this).val();
            $(_toggable).toggle();
            toggleEnderecoCorrespondencia(_answer, _toggable);
        });
    }

    function toggleEnderecoCorrespondencia(mesmo_endereco, $element) {
        if (mesmo_endereco === 'não') {
            $($element + ' input').attr('required','required');
        } else if (mesmo_endereco === 'sim') {
            $($element + ' input').removeAttr('required');
        }
    }
});