/**
 * This code is inspired by the colvis plugin for datatables, but custom made
 */

function colvis(modal, table){

    modal.find('.column input').change( function() {
        var $input = $(this);
        table.column($input.attr('name') + ":name").visible($input.is(':checked'));
    });

    modal.find('.all input').change( function() {
        $(this).parents('.columns').find('.column input').prop('checked', true).change()
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
                }
            })
        }
    };
}