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
    if ( n === false ) {
        return "#FFFFFF"
    } else if( n == 'no-data' ) {
        return "lightgray"
    } else {
        return this(n);
    }
};

var table;
var baseColors;
var lastRequest;

function loadExperiment() {
    var slider = $("#scale-slider")
        .slider({tooltip: 'always'})
        .on('slide', function() {
            // Eval is evil??
            var domain = eval( '[' + slider.getValue() + ']');
            scale.domain(domain);

            if( navInfo.getGene() ) {
                updateColors(scale);
                updateTableColors(navInfo.getMode());
            }
        }).data('slider');

    var lg = d3.select('#lg');
    var eg = d3.select('#eg');
    var hs = d3.select('#hs');

    baseColors = retrieveFillColor(hs);

    $('#change').click(function() {
        showSDWarning()
    });

    setupTooltip(eg);
    setupTooltip(lg);
    setupTooltip(hs);
    setupSDTooltip()

    table = $('#example').DataTable({
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
        var $this = $(this);

        if ( $this.hasClass('dropdown-toggle')) {
            // Dropdowns are handled in another event handler
            return;
        }

        navInfo.setMode($(this).data('mode'));
        $("#mode button").removeClass('btn-primary');
        $this.addClass('btn-primary')
    });

    $("#mode button.dropdown-toggle").parent().find('a').on('click', function(e){
        var $a = $(this);
        e.preventDefault();

        $("#mode button").removeClass('btn-primary');
        $a.closest('div').find('.dropdown-toggle').addClass('btn-primary');

        $a.closest('ul').find('span.glyphicon-ok').remove();
        $a.prepend('<span class="glyphicon glyphicon-ok"></span> ');
        navInfo.setMode($a.data('mode'));
    });

    $(window).on('alberto.mode.changed', function() {
        if ( navInfo.getMode() == "fc_spt" ) {
            slider.setAttribute('min', -10)
                .setAttribute('max', 10)
                .setValue([-5, 5])
                .refresh();

            scale.domain([-5,-1,1, 5])
                .range(["green", "black","black", "red"]);
        } else if ( navInfo.getMode() == "abs" ) {
            slider.setAttribute('min', 0)
                .setAttribute('max', 2000)
                .setValue([30, 1000])
                .refresh();

            scale.domain([0, 1000])
                .range(["yellow", "red"]);
        } else if ( navInfo.getMode() == "fc_tmp" ) {
            slider.setAttribute('min', -10)
                .setAttribute('max', 10)
                .setValue([-5, 5])
                .refresh();

            scale.domain([-5,-1,1, 5])
                .range(["green", "black","black", "red"]);
        }

        $("#scale b:first").html(slider.getAttribute('min'));
        $("#scale b:last").html(slider.getAttribute('max'));

        showColumnType(navInfo.getMode());
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

    var $dropdown = $('.dropdown-menu.actions');
    $('div.svg svg g').click(function(e) {

        $dropdown
            .fadeIn()
            .offset({left:e.pageX,top:e.pageY});

        $dropdown.data('g', this);

        $(document).one('mouseup', function (e) {
            if (!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) {
                $dropdown.hide();
            }
        });

        event.stopPropagation();
    });

    $dropdown.click(function(e) {
        e.preventDefault();
        $dropdown.hide();

        var tissue = $($dropdown.data('g')).attr('class');
        var stage =  $($dropdown.data('g')).parents('svg').attr('id');
        var column;

        if( intactRules[stage][tissue] ) {
            column = intactRules[stage][tissue].abs
        } else {
            column = intactRules[stage]['*'].abs
        }
        var columnIdx = table.column(column + ":name").index();

        if ( columnIdx == undefined ) {
            return false;
        }

        table.order([columnIdx, 'desc']);
        yadcf.exResetAllFilters(table);
        yadcf.exFilterColumn(table, [[columnIdx, {from:100}]], true);
    });

    var ngenes = $("#exportModal .ngenes").slider().data('slider');

    $("#export").click(function() {
        var d = lastRequest;

        for (var i = 0; i < d.columns.length; i++) {

            if ( $("#exportModal .visible").is(":checked") ) {
                d.columns[i].visible = true;
            } else {
                d.columns[i].visible = table.column(d.columns[i].name + ":name").visible();
            }

        }

        d.start = 0;
        d.length = ngenes.getValue();
        d.includeAnnotations = $("#exportModal .annotations").is(":checked");

        // split params into form inputs
        var inputs = '';
        var data = decodeURIComponent(jQuery.param(d));

        $.each(data.split('&'), function () {
            var pair = this.split('=');
            inputs += '<input type="hidden" name="' + pair[0] + '" value="' + pair[1] + '" />';
        });

        // Yii2 CSRF protection
        inputs += '<input name="' + yii.getCsrfParam() + '" value="' + yii.getCsrfToken() + '" type="hidden">';

        // send request
        $('<form action="/index.php?r=gene/export" method="post">' + inputs + '</form>')
            .appendTo('body').submit().remove();

    })
}

function showColumnType(type) {
    // Remove all background-color from selected row
    $("tr.selected").find('td').css('background-color','');

    // Hide all but annotation columns
    table.columns(":not('.type_ann')").visible(false, false);

    // Show column type request
    table.columns('.type_' + type).visible(true, false);

    // This seriously improves performance to do this only once, see the false as second argument to visible()
    table.columns.adjust();

    // Rebuild Show/Hide menu
    $.fn.dataTable.ColVis.fnRebuild();
}

function updateTableColors(type) {
    $("#example tbody tr.selected td.type_" + type).css('background-color', function() {
        return scale($(this).html())
    })
}

function showSDWarning() {

}

function updateColors(colorScale, useIndex) {
    $.each(tissues, function(i, tissue) {
        d3.selectAll('.' + tissue).transition().duration(1000).attr('fill', function(d) {
            if( ! useIndex && d ) {

                if( navInfo.getMode() == 'fc_spt') {
                    return colorScale.defined(d.fc_spt)
                } else if( navInfo.getMode() == 'fc_tmp' ) {
                    return colorScale.defined(d.fc_tmp)
                } else {
                    return colorScale.defined(d.abs)
                }
            } else {
                return colorScale(i)
            }
        }).each('start', function() {
            d3.select(this).attr('in-transition', 'yes')
        }).each('end', function() {
            d3.select(this).attr('in-transition', 'no')
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

function hideGeneInformation() {
    $('#gene-information .non-selected').show();
    $('#gene-information .selected').hide();
}

function parseRuleField( field, data, postfix ) {

    if ( postfix == undefined ) {
        postfix = '';
    }

    if ( field === false ) {
        return false;
    }

    if ( field == 'no-data' ) {
        return 'no-data';
    }

    if ( data[field] ) {
        return data[field + postfix];
    }
}

function loadINTACT(data) {

    $.each( intactRules, function(stageId, stage)  {
        var stageData = [];

        d3.select("#" + stageId + " g.warning-sign").attr('display','none');

        $.each(tissues, function(j, tissue) {
            var s;

            if ( stage[tissue] !== undefined ) {
                s = stage[tissue];
            } else {
                s = stage['*'];
            }

            stageData[j]= {
                name : s.name,
                abs : parseRuleField( s.abs, data),
                sd : parseRuleField( s.abs, data, '_sd'),
                fc_spt : parseRuleField( s.fc_spt, data),
                fc_tmp : parseRuleField( s.fc_tmp, data)
            };

            if ( stageData[j].sd / stageData[j].abs > 0.1 ) {
                d3.select("#" + stageId + " g.warning-sign").attr('display','inline');
            }
        });

        assignData(d3.select("#"+stageId), stageData);
    });

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
                return formatTooltip(d)
            } else {
                return "N/A";
            }
        } );

    ele.call(tip);

    $.each(tissues, function(i, tissue) {
        ele.select('.' + tissue)
            .on('mouseover', function(d, i){

                // Check for big standard deviation
                if ( d && (d.sd / d.abs) > 0.1 ) {
                    tip.attr('class', 'd3-tip large-sd')
                } else {
                    tip.attr('class', 'd3-tip')
                }

                tip.show(d, i);

                var g = d3.select(this);
                if ( g.attr('in-transition') == undefined || g.attr('in-transition') == 'no' ) {
                    g.transition().style("opacity", 0.5);
                }

            })
            .on('mouseout', function(d, i) {
                tip.hide(d, i);

                var g = d3.select(this);

                if ( g.attr('in-transition') == undefined || g.attr('in-transition') == 'no' ) {
                    g.transition().style("opacity", 1);
                }
            })
    });
}

function setupSDTooltip() {
    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .direction('e')
        .offset([0, 20])
        .html( 'A tissue in this embryo has a high standard deviation' );

    d3.select('g.warning-sign')
        .on('mouseover', function(d, i) {
            tip.show(d, i);
        })
        .on('mouseout', function(d, i) {
            tip.hide(d, i);
        });

    d3.select('#eg').call(tip);
}

function formatTooltip(d) {
    var r;

    r = "<p><span class='label label-success'>Tissue</span> " + d.name + " </p>";
    r += "<p><span class='label label-primary'>Expression value</span> " + d.abs+ "</p>";
    r += "<p class='sd'><span class='label label-primary'>Standard deviation</span> " + d.sd + "</p>";

    return r;
}

function assignData(ele, data) {

    $.each(tissues, function(i, tissue) {
        ele.select('.' + tissue)
            .data([ data[i] ])
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

function unShowGene() {
    // Revert to base colors
    updateColors(baseColors, true);

    hideGeneInformation();

    $("tbody tr.selected").removeClass("selected").find('td').css('background-color','');
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
        { data: 'gene_agi', 'class': 'type_ann', name:'gene_agi' },
        {
            data: 'gene.gene',
            render: function (data) {
                if (data) {
                    return "<span class='gene-tooltip' data-toggle='tooltip' title='" + data + "'>" + data.split(',')[0] + " </span>";
                } else {
                    return "";
                }
            },
            name: 'gene.gene',
            'class': 'type_ann'
        },
        {
            data: 'gene.annotation',
            render: function (data) {
                if (data) {
                    return "<span class='gene-tooltip' data-toggle='tooltip' title='" + data + "'>" + data.substr(0, 10) + " </span>";
                } else {
                    return "";
                }
            },
            name: 'gene.annotation',
            visible: true,
            'class': 'type_ann'
        }
    ];

    for( var i = 0; i < columns.length; i++ ) {
        r.push( { data: columns[i].field, name: columns[i].field, 'class': 'type_' + columns[i].type });

        if( columns[i].type == 'abs' ) {
            r.push({data: columns[i].field + '_sd', name: columns[i].field + '_sd', visible: false});
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
        },
        {
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
