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
