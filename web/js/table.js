/**
 * Functions for controlling the DataTable
 */

window.alberto.table = function($table, columns, filterColumns, experiment) {
    var lastRequest;

    var dt = $table.DataTable({
        serverSide: true,
        stateSave: true,
        // experiment.loaded is responsible for loading the table
        deferLoading: 0,
        stateLoadCallback: function () {
            return false;
        },
        ajax: {
            url: "/index.php?r=gene/index&exp=" + experiment ,
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

    // Setup YADCF filters
    yadcf.init(dt, filterColumns, 'header');

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

    function showColumnType(type) {
        // Remove all background-color from selected row
        $table.find("tr.selected").find('td').css('background-color', '');

        // Hide all but annotation columns
        dt.columns(":not('.type_ann')").visible(false, false);

        // Show column type request
        dt.columns('.type_' + type).visible(true, false);

        // This seriously improves performance to do this only once, see the false as second argument to visible()
        dt.columns.adjust();

        // Refresh column visibility dialog
        dt.colvis.refresh();
    }

    function getLastRequest() {
        return lastRequest;
    }

    return {
        getLastRequest: getLastRequest,
        dt: dt,
        $table: $table,
        getSelectedRow: getSelectedRow,
        showColumnType: showColumnType
    }
};
