$(document).ready(function(){

    var valueInputs = $('input[id$="value"]'),
        points = $('div[id$="points"]');

    valueInputs.each(function() {
        var childNodes = $(this).attr('child_nodes_ids').split(','),
            parentId = $(this).attr('parent_id');

        if(!parentId || (parentId && childNodes[0] != 0))
            $(this).attr('readonly', true);
    });

    valueInputs.on('change', function () {

        var parentId = $(this).attr('parent_id'),
            parentInput = points.find('input[self_id="'+ parentId + '"]'),
            parentChildNodes =
                parentInput.attr('child_nodes_ids') ? parentInput.attr('child_nodes_ids').split(',') : [],
            scores = 0;

        for(var i = 0; i < parentChildNodes.length; i++) {
            scores += +points.find('input[self_id="' + parentChildNodes[i] + '"]').val();
        }

        parentInput.val(scores).trigger('change');
    });
});
