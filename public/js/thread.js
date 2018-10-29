/**
 * Save scroll position and append hidden input element.
 * @param {Object} obj - object of the form which you want input element to be appended
 * @returns
 */
function SaveScroll(obj) {
    var scroll = $(window).scrollTop();
    $(obj).append('<input name="scroll" type="hidden" value="' + scroll + '">');
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
        console.log(content);
        $('#' + targetId).html(content);
        autosize($('textarea')); // autosize textarea here also
    });
}
