$(document).ready(function() {
    var modal_el = 'select[name="mus_EnCorrespondencia_mesmo"]';
    if ($(modal_el).length > 0) {
        var _toggable = '.entity-modal .en-correspondencia';
        $(_toggable).hide();
        $(modal_el).change( function() {
            $(_toggable).toggle();
        });
    }
});