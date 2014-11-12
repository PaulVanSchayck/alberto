var tissues = [
    'suspensor',
    'vascular-initials',
    'vascular',
    'ground-initials',
    'ground',
    'inner-upper',
    'protoderm',
    'hypophysis',
    'qc',
    'columella'
];

var scale = d3.scale.linear();

/**
 * This wraps the scale function, in order to return white whenever false or undefined is requested
 *
 * @param n
 * @returns {*}
 */
scale.defined = function(n) {
    if ( n ) {
        return this(n);
    } else {
        return "#FFFFFF"
    }
};

var table;

function loadExperiment() {
    var slider = $("#scale-slider")
        .slider({tooltip: 'always'})
        .on('slide', function() {
            // Eval is evil??
            var domain = eval( '[' + slider.getValue() + ']');
            scale.domain(domain);
            updateColors(scale);
            updateTableColors(navInfo.getMode());
        }).data('slider');

    var lg = d3.select('#lg');
    var eg = d3.select('#eg');
    var hs = d3.select('#hs');

    var baseColors = retrieveFillColor(hs);

    $('#change').click(function() {
        updateColors(d3.scale.category20(), true);
    });

    $('#original').click(function() {
        updateColors(baseColors, true);
    });

    setupTooltip(eg);
    setupTooltip(lg);
    setupTooltip(hs);

    table = $('#example').DataTable({
        serverSide: true,
        stateSave: true,
        // experiment.loaded is responsible for loading the table
        deferLoading: 0,
        stateLoadCallback: function () {
            return false;
        },
        ajax: {
            url: "http://bic-hp-z400/index.php?r=gene/index",
            method: "get",
            dataSrc: "data"
        },
        columns: buildDTColumns(intactColumns),
        dom: 'C<"clear">rtiS',
        scrollY: 500,
        scrollX: "100%",
        processing: true,
        scroller: {
            loadingIndicator: true
        }
    });

    // Setup YADCF filters
    yadcf.init(table, buildFilterColumns(intactColumns), 'header');

    $('#example').on( 'search.dt', function () {
        $(".filter_column input").removeClass('filtered');
        $(".filter_column input").each(function() {
            if( $(this).val() != '' ) {
                $(this).addClass('filtered');
            }
        });
        return true;
    });

    table.on( 'draw.dt', function(){
        $("#example").find('span[data-toggle=tooltip]').tooltip({'placement': 'bottom'});
    } );

    // Handle table clicks
    $('tbody').on( 'click', 'tr', function () {
        var data = table.row(this).data();
        navInfo.setGene(data.gene_agi, true);
        loadGeneFromRow(this);
    } );

    $("#mode button").tooltip({'placement': 'bottom', container: 'body'});

    $("#gene-information .non-selected").tooltip({'placement': 'bottom'});

    $(".download-svg").click(function(e) {
        e.preventDefault();
        saveAsSVG($(this).parents('.panel').find('svg')[0],$(this).attr('title').replace('gene',navInfo.getGene()));
    });

    $(".download-png").click(function(e) {
        e.preventDefault();
        saveAsPNG($(this).parents('.panel').find('svg')[0],$(this).attr('title').replace('gene',navInfo.getGene()));
    });

    $("#mode button").click( function() {
        navInfo.setMode($(this).data('mode'));
        $("#mode button").removeClass('btn-primary');
        $(this).addClass('btn-primary')
    });

    $(window).on('alberto.mode.changed', function() {
        if ( navInfo.getMode() == "fc" ) {
            slider.setAttribute('min', -10)
                .setAttribute('max', 10)
                .setValue([-5, 5])
                .refresh();

            showColumnType('fc');

            scale.domain([-5,-1,1, 5])
                .range(["green", "black","black", "red"]);
        } else if ( navInfo.getMode() == "abs" ) {
            slider.setAttribute('min', 0)
                .setAttribute('max', 1000)
                .setValue([30, 1000])
                .refresh();

            showColumnType('abs');

            scale.domain([0, 1000])
                .range(["yellow", "red"]);
        }

        showScale(scale);

        if( navInfo.getGene() ) {
            updateColors(scale);
            updateTableColors(navInfo.getMode());
        }
    });

    $(window).trigger('experiment.loaded');

    // If no mode is selected, set the absolute expression mode
    if(! navInfo.getMode() ) {
         $("#mode button").first().click();
    }
}

function showColumnType(type) {
    // Hide all but annotation columns
    table.columns(":not('.type_ann')").visible(false, false);

    // Show column type request
    table.columns('.type_' + type).visible(true, false);

    // This late redraw makes for a flash of unstyled content, but seriously improves performance to do this only once
    table.draw();

    // Rebuild Show/Hide menu
    $.fn.dataTable.ColVis.fnRebuild();
}

function updateTableColors(type) {
    $("#example tbody tr.selected td.type_" + type).css('background-color', function() {
        return scale($(this).html())
    })
}

function updateColors(colorScale, useIndex) {
    $.each(tissues, function(i, tissue) {
        d3.selectAll('.' + tissue).transition().duration(1000).attr('fill', function(d) {
            if( ! useIndex && d ) {

                if( navInfo.getMode() == 'fc') {
                    return colorScale.defined(d.value.fc)
                } else {
                    return colorScale.defined(d.value.exp)
                }
            } else {
                return colorScale(i)
            }
        })
    });
}

function showScale(colorScale) {
    var div = d3.select(".slider-selection").selectAll('div')
        .data(colorScale.ticks(20).slice(0,19));

    div.enter().append('div')
        .attr('class','slider-scale');

    div.style('background-color',function(d) { return colorScale(d) });

}

function showGeneInformation(data) {
    $('#gene-information .non-selected').hide();
    var $gene = $('#gene-information .selected').show();


    $gene.find('.agi').html(data.gene_agi);
    $gene.find('.annotation').html(data.gene.annotation);
    $gene.find('.gene').html(data.gene.gene);

    $gene.find('#tools li a').each(function(i,e){
       $(e).attr('href', function() {
           return $(this).data('template').replace('#AGI#', data.gene_agi);
       });
    });
}

function loadINTACT(data) {
    var suspensor_eg = ['suspensor'];
    var vascular_eg = ['vascular', 'vascular-initials'];
    var embryo_eg = ['ground-initials', 'ground', 'inner-upper','protoderm', 'hypophysis', 'qc','columella'];

    var vascular_lg = ['vascular', 'vascular-initials'];
    var embryo_lg = ['suspensor', 'ground-initials', 'ground', 'inner-upper','protoderm', 'hypophysis', 'qc','columella'];

    var qc_hs = ['qc'];

    var dataEG = [], dataLG = [], dataHS = [];
    $.each(tissues, function(i, tissue) {
        if( suspensor_eg.indexOf(tissue) > -1 ) {
            dataEG[i] = { exp: data.suspensor_eg, sd: data.suspensor_eg_sd, fc: data.fc_suspensor_eg_embryo_eg };
        }
        if( vascular_eg.indexOf(tissue) > -1 ) {
            dataEG[i] = { exp: data.vascular_eg, sd: data.vascular_eg_sd,  fc: data.fc_vascular_eg_embryo_eg};
        }
        if( embryo_eg.indexOf(tissue) > -1 ) {
            dataEG[i] = { exp: data.embryo_eg, sd: data.embryo_eg_sd, fc: false };
        }

        if( vascular_lg.indexOf(tissue) > -1 ) {
            dataLG[i] = { exp: data.vascular_lg, sd: data.vascular_lg_sd, fc: data.fc_vascular_lg_embryo_lg };
        }
        if( embryo_lg.indexOf(tissue) > -1 ) {
            dataLG[i] = { exp: data.embryo_lg, sd: data.embryo_lg_sd, fc: false };
        }

        if( qc_hs.indexOf(tissue) > -1 ) {
            dataHS[i] = { exp: data.qc_hs, sd: data.qc_hs_sd, fc: false };
        } else {
            dataHS[i] = { exp: false, sd: false, fc: false };
        }
    });

    var eg = d3.select('#eg'), lg = d3.select('#lg'), hs = d3.select('#hs');

    assignData(lg, dataLG);
    assignData(eg, dataEG);
    assignData(hs, dataHS);

    updateColors(scale);
}

function retrieveFillColor(ele) {
    var color = [];

    $.each(tissues, function(i, tissue) {
        if ( ! ele.select('.' + tissue).empty() ) {
            color[i] = ele.select('.' + tissue).attr('fill');
        }
    });

    return d3.scale.ordinal().range(color);
}

function setupTooltip(ele) {
    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .direction('e')
        .offset([0, 20])
        .html( function(d) {
            if ( d ) {
                return d.tissue + "<br /> Expression value: " + d.value.exp + "<br /> SD: " + d.value.sd;
            } else {
                return "N/A";
            }
        } );

    ele.call(tip);

    $.each(tissues, function(i, tissue) {
        ele.select('.' + tissue)
            .on('mouseover', function(d, i){

                // Check for big standard deviation
                if ( d && (d.value.sd / d.value.exp) > 0.1 ) {
                    tip.attr('class', 'd3-tip large-sd')
                } else {
                    tip.style('class', 'd3-tip')
                }

                tip.show(d, i);
                d3.select(this).transition().style("opacity", 0.5);
            })
            .on('mouseout', function(d, i) {
                tip.hide(d, i);
                d3.select(this).transition().style("opacity", 1);
            })
    });
}

function assignData(ele, data) {

    $.each(tissues, function(i, tissue) {
        ele.select('.' + tissue)
            .data([{'tissue' : tissue, 'value' : data[i]}])
    });
}

function showGene(gene) {
    yadcf.exFilterColumn(table, [[0, gene]], true);

    table.one( 'draw.dt', function() {
        if( table.data().length > 0 ) {
            loadGeneFromRow('#example tbody tr:eq(0)');
        } else {
            $("#no-results").show();
        }
    } );
}

function loadGeneFromRow(row) {
    $("tbody tr.selected").removeClass("selected").find('td').css('background-color','');
    $(row).addClass("selected");
    updateTableColors(navInfo.getMode());

    var data = table.row(row).data();

    loadINTACT(data);
    showGeneInformation(data);
}

function buildDTColumns(columns) {
    var r = [
        { data: 'gene_agi', 'class': 'type_ann' },
        {
            data: 'gene.gene',
            render: function (data, type, row) {
                if (data) {
                    return "<span class='gene-tooltip' data-toggle='tooltip' title='" + data + row.gene.annotation + "'>" + data.split(',')[0] + " </span>";
                } else {
                    return "";
                }
            },
            'class': 'type_ann'
        }
    ];

    for( var i = 0; i < columns.length; i++ ) {
        r.push( { data: columns[i].field, name: 'range', 'class': 'type_' + columns[i].type });

        if( columns[i].type == 'abs' ) {
            r.push({data: columns[i].field + '_sd', name: 'range', visible: false});
        }
    }

    return r;
}

function buildFilterColumns(columns) {
    var column_number = 0;
    var r = [
        {
            column_number: column_number++,
            filter_type: "text",
            filter_delay: 500
        }, {
            column_number: column_number++,
            filter_type: "text",
            filter_delay: 500
        }
    ];

    for( var i = 0; i < columns.length; i++ ) {
        r.push( {
            column_number: column_number++,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        });
        if( columns[i].type == 'abs' ) {
            r.push({
                column_number: column_number++,
                filter_type: "range_number",
                filter_default_label: ["0", "&infin;"],
                filter_delay: 500
            });
        }
    }

    return r;
}
