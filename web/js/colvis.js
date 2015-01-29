/**
 * This code is inspired by the colvis plugin for datatables, but custom made
 */

function colvis(modal, table){

    modal.find('.field input').change( function(e, redraw) {
        if ( redraw == undefined ) {
            redraw = true;
        }
        var $input = $(this);
        table.column($input.attr('id') + ":name").visible($input.is(':checked'), redraw);
    });

    modal.find('.all input').change( function() {
        var $this = $(this);

        var idx = $this.parents('td').index();

        $(this).parents('.columns').find('tr.field td:nth-of-type('+ (idx + 1) +') input').prop('checked', $this.is(':checked')).trigger('change', [false]);

        // This seriously increases performance, when mass changing column visibility
        table.columns.adjust();
    });

    // Refresh checkboxes when modal is shown
    modal.on('show.bs.modal', function() {
        modal.find('input').each(function(i, input) {
            var $input = $(input);
            var visible = table.column($input.attr('id') + ":name").visible();

            if ( visible === true ) {
                $input.prop('checked', true)
            } else {
                $input.prop('checked', false)
            }
        })
    });

    return {
        modal: modal,
        table: table
    };
}