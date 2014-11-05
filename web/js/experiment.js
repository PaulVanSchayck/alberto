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

var scale = d3.scale.linear().clamp(true)
    .domain([0, 1000])
    .range(["yellow", "red"]);

var table;

function loadExperiment() {

    var slider = $("#scale-slider")
        .slider({tooltip: 'always'})
        .on('slide', function() {
            // Eval is evil??
            var domain = eval( '[' + slider.getValue() + ']');
            scale = scale.domain(domain);
            updateColors(scale);
            //updateTableColors();
        }).data('slider');

    showScale(scale);

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
        columns: [
            { data: 'agi' },
            { data: 'geneShort' },
            { data: 'int17_eg', 'name': 'range' },
            { data: 'iqd15_eg', 'name': 'range' },
            { data: 'rps5a_eg', 'name': 'range' },
            { data: 'iqd15_lg', 'name': 'range' },
            { data: 'rps5a_lg', 'name': 'range' },
            { data: 'wox5_hs', 'name': 'range' },
            { data: 'fc', 'name': 'range' }
        ],
        dom: 'C<"clear">rtiS',
        scrollY: 500,
        scrollX: "100%",
        processing: true,
        scroller: {
            loadingIndicator: true
        }
    });

    // Take note of the lowercase dataTable, this is the old API
    yadcf.init(table, [{
            column_number: 0,
            filter_type: "text",
            filter_delay: 500
        }, {
            column_number: 1,
            filter_type: "text",
            filter_delay: 500
        }, {
            column_number: 2,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500

        }, {
            column_number: 3,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        }, {
            column_number: 4,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        }, {
            column_number: 5,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        }, {
            column_number: 6,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        }, {
            column_number: 7,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        }, {
            column_number: 8,
            filter_type: "range_number",
            filter_default_label : ["0", "&infin;"],
            filter_delay: 500
        }], 'header');

    $('#example').on( 'search.dt', function () {
        $(".filter_column input").removeClass('filtered');
        $(".filter_column input").each(function() {
            if( $(this).val() != '' ) {
                $(this).addClass('filtered');
            }
        });
        return true;
    });

    // Handle table clicks
    $('tbody').on( 'click', 'tr', function () {
        var data = table.row(this).data();
        //navInfo.setGene(data.agi, true);
        loadGeneFromRow(this);
    } );

    $("#mode button").tooltip({'placement': 'bottom'});

    $("#gene-information .non-selected").tooltip({'placement': 'bottom'});

    $('#example').on( 'draw.dt', updateTableColors );

    $(".download-svg").click(function(e) {
        e.preventDefault();
        saveAsSVG($(this).parents('.panel').find('svg')[0],$(this).attr('title'));
    });

    $(".download-png").click(function(e) {
        e.preventDefault();
        saveAsPNG($(this).parents('.panel').find('svg')[0],$(this).attr('title'));
    });

    $(window).trigger('experiment.loaded');
}

function updateTableColors() {
    /*$("#example tbody td").css('color', function() {
        return scale($(this).html())
    })*/
}

function updateColors(colorScale, useIndex) {
    $.each(tissues, function(i, tissue) {
        d3.selectAll('.' + tissue).transition().duration(1000).attr('fill', function(d) {
            if( ! useIndex && d && d.value) {
                return colorScale(d.value)
            } else {
                return colorScale(i)
            }
        })
    });
}

function showScale(colorScale) {
    d3.select(".slider-selection").selectAll('div')
        .data(d3.range(1, 1000, 50))
        .enter()
        .append('div')
        .attr('style','float: left;width:5%;height:10px;')
        .style('background-color',function(d) { return colorScale(d) });
}

function showGeneInformation(data) {
    $('#gene-information .non-selected').hide();
    $gene = $('#gene-information .selected').show();


    $gene.find('.agi').html(data.agi);
    $gene.find('.annotation').html(data.annotation);
    $gene.find('.gene').html(data.gene);

    $gene.find('#tools li a').each(function(i,e){
       $(e).attr('href', function() {
           return $(this).data('template').replace('#AGI#', data.agi);
       });
    });
}

function loadINTACT(data) {
    var int17_eg = ['suspensor'];
    var iqd15_eg = ['vascular', 'vascular-initials'];
    var rps5a_eg = ['ground-initials', 'ground', 'inner-upper','protoderm', 'hypophysis', 'qc','columella'];

    var iqd15_lg = ['vascular', 'vascular-initials'];
    var rps5a_lg = ['suspensor', 'ground-initials', 'ground', 'inner-upper','protoderm', 'hypophysis', 'qc','columella'];

    var wox5_hs = ['qc'];

    var dataEG = [], dataLG = [], dataHS = [];
    $.each(tissues, function(i, tissue) {
        if( int17_eg.indexOf(tissue) > -1 ) {
            dataEG[i] = data.int17_eg;
        }
        if( iqd15_eg.indexOf(tissue) > -1 ) {
            dataEG[i] = data.iqd15_eg;
        }
        if( rps5a_eg.indexOf(tissue) > -1 ) {
            dataEG[i] = data.rps5a_eg;
        }

        if( iqd15_lg.indexOf(tissue) > -1 ) {
            dataLG[i] = data.iqd15_lg;
        }
        if( rps5a_lg.indexOf(tissue) > -1 ) {
            dataLG[i] = data.rps5a_lg;
        }

        if( wox5_hs.indexOf(tissue) > -1 ) {
            dataHS[i] = data.wox5_hs;
        } else {
            dataHS[i] = 0;
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
                return d.tissue + "<br /> Expression value: " + d.value;
            } else {
                return "N/A";
            }
        } );

    ele.call(tip);

    $.each(tissues, function(i, tissue) {
        ele.select('.' + tissue)
            .on('mouseover', function(d, i){
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

    table.one( 'draw.dt', function(){
        loadGeneFromRow('#example tbody tr:eq(0)');
    } );
}

function loadGeneFromRow(row) {
    $("tbody tr.selected").removeClass("selected");
    $(row).addClass("selected");
    var data = table.row(row).data();

    loadINTACT(data);
    showGeneInformation(data);
}