/**
 * This code is inspired by the colvis plugin for datatables, but custom made
 */

function colvis(modal, table){

    modal.find('.column input').change( function(e, redraw) {
        if ( redraw == undefined ) {
            redraw = true;
        }
        var $input = $(this);
        table.column($input.attr('name') + ":name").visible($input.is(':checked'), redraw);
    });

    modal.find('.all input').change( function() {
        var $this = $(this);

        var selector = $this.is(':first-of-type') ? '.column input:first-of-type' : '.column input:last-of-type';

        $(this).parents('.columns').find(selector).prop('checked', $this.is(':checked')).trigger('change', [false]);

        // This seriously increases performance, when mass changing column visibility
        table.columns.adjust();
    });

    return {
        modal: modal,
        table: table,

        refresh: function () {
            var table = this.table;

            this.modal.find('input').each(function(i, input) {
                var $input = $(input);
                var visible = table.column($input.attr('name') + ":name").visible();

                if ( visible === true ) {
                    $input.prop('checked', true)
                } else {
                    $input.prop('checked', false)
                }
            })
        }
    };
}