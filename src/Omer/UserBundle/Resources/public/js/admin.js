$(document).ready(function(){

    reinitSelectFromMultipleToSingle($("select[id$='_roles']"));

    function reinitSelectFromMultipleToSingle($selector) {
        $selector.removeAttr('multiple');
        $selector.select2({
            width: "100%"
        });
    }
});

