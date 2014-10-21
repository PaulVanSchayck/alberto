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

$(document).ready(function(){
    var lg = d3.select('#lg');
    var eg = d3.select('#eg');
    var hs = d3.select('#hs');

    baseColors = {
        'eg' : retrieveFillColor(eg),
        'lg' : retrieveFillColor(lg),
        'hs' : retrieveFillColor(hs)
    };

    $('#change').click(function() {
        var color = d3.scale.category20();
        colorCellTypes(lg, color);
        colorCellTypes(eg, color);
        colorCellTypes(hs, color)
    });

    $('#original').click(function() {
        colorCellTypes(lg, baseColors.lg);
        colorCellTypes(eg, baseColors.eg);
        colorCellTypes(hs, baseColors.hs)
    });

    setupTooltip(eg);
    setupTooltip(lg);
    setupTooltip(hs);

    assignData(eg);
    assignData(lg);
    assignData(hs);

    $(".experiments a").tooltip({'placement': 'bottom'});

    $('#example').DataTable();
});

function colorCellTypes(ele, color) {
    $.each(tissues, function(i, tissue) {
        ele.select('#' + tissue).transition().duration(1000).attr('fill',color(i))
    });

}

function retrieveFillColor(ele) {
    var color = [];

    $.each(tissues, function(i, tissue) {
        if ( ! ele.select('#' + tissue).empty() ) {
            color[i] = ele.select('#' + tissue).attr('fill');
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
            return d.tissue + "<br /> Expression value: " + d.value;
        } );

    ele.call(tip);

    $.each(tissues, function(i, tissue) {
        ele.select('#' + tissue)
            //.on('mouseover', tip.show)
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

function assignData(ele) {

    $.each(tissues, function(i, tissue) {
        ele.select('#' + tissue)
            .data([{'tissue' : tissue, 'value' : Math.round(Math.random() * 100)}])
    });
}