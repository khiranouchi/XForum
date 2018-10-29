/**
 * Show and hide the display of block element.
 * Also change the text of the switch.
 * @param {Object} obj - object of the tag of the switch
 * @param {String} targetId - id of the tag which you want to be folded
 */
function ShowHideBlock(switchObj, targetId) {
    if ($("#" + targetId).css('display') === 'none') {
        $("#" + targetId).css('display', 'block');
        $(switchObj).html('&#x25b2;');
    } else {
        $("#" + targetId).css('display', 'none');
        $(switchObj).html('&#x25bc;');
    }
}

/**
 * Show check dialog.
 * Prevent default if not confirmed.
 */
function ShowCheckDialog(message="Do you really submit?") {
    if (!confirm(message)) {
        event.preventDefault();
    }
}

/**
 * Switch the specified content to edit form.
 * @param {String} targetId - id of the element whose content you want be replaced
 * @param {String} path - url path to GET edit form
 * @returns
 */
function SwitchToEditMode(targetId, path) {
    $.ajax({
        type: 'GET',
        url: path,
        cache: false,
        async: true
    }).done(function(content){
        $('#' + targetId).html(content);
        autosize($('textarea')); // autosize textarea here also
    });
}
