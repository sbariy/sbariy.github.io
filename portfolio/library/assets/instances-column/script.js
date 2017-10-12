/**
 * Created by Alex on 04.05.2016.
 */

$(document).popover({selector: '.instances-toggler', trigger: 'hover focus'});
$(document).on('click', '.instances-toggler', function (event) {
    event.stopPropagation();
});