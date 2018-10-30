/**
 * Save scroll position and append hidden input element.
 * @param {Object} obj - object of the form which you want input element to be appended
 * @returns
 */
function SaveScroll(obj) {
    var scroll = $(window).scrollTop();
    $(obj).append('<input name="scroll" type="hidden" value="' + scroll + '">');
}
