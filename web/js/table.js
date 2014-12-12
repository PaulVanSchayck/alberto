/**
 * Functions for controlling the DataTable
 */

window.alberto.table = function($table, columns) {
    var dt = $table.DataTable({
        serverSide: true,
        stateSave: true,
        // experiment.loaded is responsible for loading the table
        deferLoading: 0,
        stateLoadCallback: function () {
            return false;
        },
        ajax: {
            url: "/index.php?r=gene/index",
            method: "post",
            dataSrc: "data",
            data: function(d) {
                // Delete some variables which we will not use, this will reduce the size of the request
                delete d.search;

                for(var i =0; i < d.columns.length; i++) {
                    delete d.columns[i].orderable;
                    delete d.columns[i].searchable;
                    delete d.columns[i].search.regex;
                }

                // Store the build request for export purposes
                lastRequest = d;
            }
        },
        columns: columns,
        dom: 'rtiS',
        scrollY: 500,
        scrollX: "100%",
        processing: true,
        scroller: {
            loadingIndicator: true
        },
        infoCallback: function( settings, start, end, max, total, pre ) {
            return pre + " ordered by " + settings.aoColumns[settings.aaSorting[0][0]].sTitle
        }
    });

    dt.on( 'search.dt', function () {
        $(".filter_column input")
            .removeClass('filtered')
            .each(function() {
                if( $(this).val() != '' ) {
                    $(this).addClass('filtered');
                }
        });

        return true;
    });

    dt.on( 'draw.dt', function(){
        $table.find('span[data-toggle=tooltip]').tooltip({'placement': 'bottom'});
    } );

    // Handle table clicks
    $table.on( 'click', 'tr', function () {
        $table.find("tr.selected")
            .removeClass("selected")
            .find('td').css('background-color', '').css('color', '');

        $(this).addClass("selected");

        var data = dt.row(this).data();
        navInfo.setGene(data.gene_agi, true);
    } );

    function getSelectedRow() {
        return $table.find('tr.selected');
    }

    return {
        dt: dt,
        $table: $table,
        getSelectedRow: getSelectedRow
    }
};
