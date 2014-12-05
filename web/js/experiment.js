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

var rsdWarning = 50;
var qWarning = 0.05;

function loadExperiment() {

    // Scale settings

    var slider = $("#intact .scale-slider")
        .slider({tooltip: 'always'})
        .on('slide', function() {
            // Eval is evil??
            var domain = eval( '[' + slider.getValue() + ']');

            if ( navInfo.getMode() == "fc_spt" ||  navInfo.getMode() == "fc_tmp") {
                scale.domain([domain[0], -1, 1, domain[1]]);
            } else {
                scale.domain(domain);
            }


            if( navInfo.getGene() ) {
                updateColors(scale);
                updateTableColors(navInfo.getMode());
            }
        }).data('slider').disable();

    $("#intact .scale-input").change(function() {
        if ( $(this).is(":checked") ) {
            slider.enable()
        } else {
            slider.disable()
        }
    });

    // Allow to change scale through clicking badge
    $("#intact .scale").on('click', '.badge', function() {
        if ( !$("#intact .scale-input").is(':checked') ) {
            return false;
        }
        var $this = $(this);
        var val = $this.text();
        var $input = $('<input class="scale-domain" value=' + val + '>').on('change, focusout', function() {
            var attr, $this = $(this);

            if ( ! $.isNumeric($this.val()) ) {
                return false;
            }

            if ( $this.prevAll('.slider').length !== 0 ) {
                attr = 'max'
            } else {
                attr = 'min'
            }

            // Refresh slider and the scale through triggering a slide event
            slider.setAttribute(attr, parseInt($this.val())).refresh();
            $("#intact .scale-slider").trigger('slide');

            $this.replaceWith('<b class="badge">' + $this.val() + '</b>');
        });
        $this.replaceWith($input);
        $input.focus()
    });

    // SVG images

    var lg = d3.select('#intact .lg');
    var eg = d3.select('#intact .eg');
    var hs = d3.select('#intact .hs');

    baseColors = retrieveFillColor(hs);

    setupTooltip(eg); setupSDTooltip(eg);
    setupTooltip(lg); setupSDTooltip(lg);
    setupTooltip(hs); setupSDTooltip(hs);

    table = $('#intactTable').DataTable({
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
    yadcf.init(table, buildFilterColumns(intactColumns), 'header');

    $('#intactTable').on( 'search.dt', function () {
        $(".filter_column input").removeClass('filtered');
        $(".filter_column input").each(function() {
            if( $(this).val() != '' ) {
                $(this).addClass('filtered');
            }
        });
        return true;
    });

    table.on( 'draw.dt', function(){
        $("#intactTable").find('span[data-toggle=tooltip]').tooltip({'placement': 'bottom'});
    } );

    // Poor mans method of injecting code into DataTables api
    table.colvis = colvis($("#visibilityModal"), table);

    // Handle table clicks
    $('#intactTable tbody').on( 'click', 'tr', function () {
        var data = table.row(this).data();
        navInfo.setGene(data.gene_agi, true);
        loadGeneFromRow(this);
    } );

    $("#intact .mode button").tooltip({placement: 'bottom', container: 'body'});

    $("#intact .gene-information .non-selected").tooltip({placement: 'bottom'});
    $("#intact .scale label").tooltip({placement: 'bottom'});

    $("#intact .mode button").click( function() {
        var $this = $(this);

        if ( $this.hasClass('dropdown-toggle')) {
            // Dropdowns are handled in another event handler
            return;
        }

        navInfo.setMode($(this).data('mode'));
    });

    $("#intact .mode button.dropdown-toggle").parent().find('a').on('click', function(e){
        var $a = $(this);
        e.preventDefault();

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
                .setAttribute('max', 200)
                .setValue([32, 100])
                .refresh();

            scale.domain([32, 100])
                .range(["yellow", "red"]);
        } else if ( navInfo.getMode() == "fc_tmp" ) {
            slider.setAttribute('min', -10)
                .setAttribute('max', 10)
                .setValue([-5, 5])
                .refresh();

            scale.domain([-5,-1,1, 5])
                .range(["green", "black","black", "red"]);
        }

        $("#intact .scale b:first").html(slider.getAttribute('min'));
        $("#intact .scale b:last").html(slider.getAttribute('max'));

        $("#intact").removeClass('abs fc_spt fc_tmp').addClass(navInfo.getMode());
        highlightActiveMode(navInfo.getMode());

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
         $("#intact .mode button").first().click();
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

    $dropdown.find('a').click(function(e) {
        e.preventDefault();
        $dropdown.hide();

        var tissue = $($dropdown.data('g')).attr('class');
        var stage =  $($dropdown.data('g')).parents('svg').attr('class');
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

        if ( $(this).hasClass('highest') ) {
            navInfo.setMode('abs');

            table.order([columnIdx, 'desc']);
            yadcf.exResetAllFilters(table);
            yadcf.exFilterColumn(table, [[columnIdx, {from: 100}]], true);

            return false;
        }

        if ( $(this).hasClass('not-expressed') ) {
            navInfo.setMode('abs');

            table.order([columnIdx, 'asc']);
            yadcf.exResetAllFilters(table);
            yadcf.exFilterColumn(table, [[columnIdx, {to: 32}]], true);

            return false;
        }

        if ( $(this).hasClass('enriched') ) {
            navInfo.setMode('fc_spt');

            columnIdx = table.column(intactRules[stage][tissue].fc_spt + ":name").index();

            yadcf.exResetAllFilters(table, true);

            var filter = [
                [columnIdx, {from: 2}]
            ];

            if ( $(this).hasClass('significant') ) {
                table.column(columnIdx + 1).visible(true);
                filter.push([columnIdx + 1, {to: 0.05}])
            }

            yadcf.exFilterColumn(table, filter, true);

            table.order([columnIdx, 'asc']);

            return false;
        }
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
        d.includeAnnotations = $("#exportModal .annotations").is(":checked") ? 1 : 0;

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
    });

    $("#intact .clearfilters").click( function() {
        yadcf.exResetAllFilters(table);
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

    // Refresh column visibility dialog
    table.colvis.refresh();
}

function updateTableColors(type) {
    $("#intactTable tbody tr.selected td.type_" + type)
        .css('background-color', function() {
            return scale($(this).html())
        })
        .css('color', function() {
            // Find contrasting color
            // From: http://ux.stackexchange.com/questions/8297/choosing-high-contrast-text-color-in-relation-to-background-color-dynamically
            var c = d3.rgb(scale($(this).html()));

            var y = 0.2126 * Math.pow(c.r/255,2.2)  +  0.7151 * Math.pow(c.g/255,2.2)  +  0.0721 * Math.pow(c.b/255,2.2);

            if ( y > 0.25 ) {
                return 'black';
            } else {
                return 'white'
            }
        });
}

function updateColors(colorScale, useIndex) {
    $.each(tissues, function(i, tissue) {
        d3.selectAll('#intact .' + tissue).transition().duration(1000).attr('fill', function(d) {
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
    var ticks = colorScale.ticks(20);

    var div = d3.select("#intact .slider-selection").selectAll('div')
        .data(ticks);

    div.enter().append('div')
        .attr('class','slider-scale');

    div.exit().remove();

    div
        .style('background-color',function(d) { return colorScale(d) })
        .style('width', (Math.floor(100 / ticks.length * 10) / 10) + "%");

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
        var stageData = [], warning = { 'abs' : false, 'fc_spt': false, 'fc_tmp': false };

        d3.select("#intact ." + stageId + " g.warning-sign").classed(warning);

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
                rsd : parseRuleField( s.abs, data, '_rsd'),
                fc_spt : parseRuleField( s.fc_spt, data),
                fc_spt_q : parseRuleField( s.fc_spt, data,'_q'),
                fc_tmp : parseRuleField( s.fc_tmp, data),
                fc_tmp_q : parseRuleField( s.fc_tmp, data,'_q')
            };

            warning = {
                'abs': stageData[j].rsd > rsdWarning && !warning.abs ? true : warning.abs ,
                'fc_spt': stageData[j].fc_spt_q > qWarning && !warning.fc_spt ? true : warning.fc_spt,
                'fc_tmp': stageData[j].fc_tmp_q > qWarning && !warning.fc_tmp ? true : warning.fc_tmp
            };
        });

        d3.select("#intact ." + stageId + " g.warning-sign").classed(warning);

        assignData(d3.select("#intact ."+stageId), stageData);
    });

    updateColors(scale);
}

function highlightActiveMode(mode) {
    $("#intact .mode button").removeClass('btn-primary');
    $("#intact .mode li").removeClass('active');

    $("#intact .mode button[data-mode="+mode+"]").addClass('btn-primary');

    $("#intact .mode li a[data-mode="+mode+"]")
        .closest('li').addClass('active')
        .closest('div').find('button').addClass('btn-primary');
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

                tip.show(d, i);

                var g = d3.select(this);
                if ( g.attr('in-transition') == undefined || g.attr('in-transition') == 'no' ) {
                    g.transition().style("opacity", 0.5);
                }

                var $g = $(this);
                var tissue = $g.attr('class');
                var stage =  $g.parents('svg').attr('class');
                var column;

                if( intactRules[stage][tissue] ) {
                    column = intactRules[stage][tissue].abs
                } else {
                    column = intactRules[stage]['*'].abs
                }
                var columnIdx = table.column(column + ":name").index();

                $(table.column( columnIdx ).nodes()).addClass('highlight');

            })
            .on('mouseout', function(d, i) {
                tip.hide(d, i);

                var g = d3.select(this);

                if ( g.attr('in-transition') == undefined || g.attr('in-transition') == 'no' ) {
                    g.transition().style("opacity", 1);
                }
                $( table.cells().nodes() ).removeClass( 'highlight' );
            })
    });
}

function setupSDTooltip(ele) {
    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .direction('e')
        .offset([0, 20])
        .html( function() {
            if ( navInfo.getMode() == 'abs' ) {
                return 'A tissue in this embryo has a relative standard deviation above 50%'
            } else {
                return 'A fold change in this embryo has a q-value above 0.05'
            }
        } );

    ele.select('g.warning-sign')
        .on('mouseover', function(d, i) {
            tip.show(d, i);
        })
        .on('mouseout', function(d, i) {
            tip.hide(d, i);
        });

    ele.call(tip);
}

function formatTooltip(d) {
    var r, warning;

    r = "<p><span class='label label-success'>Tissue</span> " + d.name + " </p>";

    if ( navInfo.getMode() == "abs" ) {
        r += "<p><span class='label label-primary'>Expression value</span> " + d.abs+ "</p>";
        warning = d.rsd > rsdWarning ? 'warning' : '';
        r += "<p class='sd " + warning + "'><span class='label label-primary'>Standard deviation</span> " + d.sd + "</p>";
        r += "<p class='sd " + warning + "'><span class='label label-primary'>%RSD</span> " + (d.rsd.toFixed ? d.rsd.toFixed(1) + "%" : d.rsd) + "</p>";
    }

    if ( navInfo.getMode() == "fc_spt" && d.fc_spt ) {
        warning = d.fc_spt_q > qWarning ? 'warning' : '';
        r += "<p><span class='label label-primary'>Spatial FC</span> " + d.fc_spt + "</p>";
        r += "<p class='q " + warning + "'><span class='label label-primary'>q-value</span> " + d.fc_spt_q + "</p>";
    }

    if ( navInfo.getMode() == "fc_tmp" && d.fc_tmp ) {
        warning = d.fc_tmp_q > qWarning ? 'warning' : '';
        r += "<p><span class='label label-primary'>Temporal FC</span> " + d.fc_tmp + "</p>";
        r += "<p class='q " + warning + "'><span class='label label-primary'>q-value</span> " + d.fc_tmp_q + "</p>";
    }

    r += "<p>Click tissue for actions</p>";

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
            loadGeneFromRow('#intactTable tbody tr:eq(0)');
        } else {
            $("#no-results").show();
        }
    } );
}

function unShowGene() {
    // Revert to base colors
    updateColors(baseColors, true);

    hideGeneInformation();

    $("tbody tr.selected").removeClass("selected").find('td').css('background-color','').css('color','');
}

function loadGeneFromRow(row) {
    $("tbody tr.selected").removeClass("selected").find('td').css('background-color','').css('color','');
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
        r.push( { data: columns[i].field, name: columns[i].field, 'class': 'type_' + columns[i].type, orderSequence:['desc','asc'] });

        if( columns[i].type == 'abs' ) {
            r.push({
                data: columns[i].field + '_rsd',
                name: columns[i].field + '_rsd',
                render: function (data) {
                    if ( data > rsdWarning) {
                        return "<span class='sd-warning'>" + data.toFixed(1) + " </span>";
                    } else {
                         return data.toFixed(1);
                    }
                },
                'class': 'type_rsd',
                visible: true,
                orderSequence:['desc','asc']
            });
            r.push({
                data: columns[i].field + '_sd',
                name: columns[i].field + '_sd',
                'class': 'type_sd',
                visible: false,
                orderSequence:['desc','asc']
            });
        } else if (columns[i].type == 'fc_tmp' || columns[i].type == 'fc_spt') {
            r.push({data: columns[i].field + '_q', name: columns[i].field + '_q', visible: false, orderSequence:['desc','asc']});
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
        if( columns[i].type == 'abs' ) {
            r.push( {
                column_number: column_number++,
                filter_type: "range_number",
                filter_default_label : ["0", "&infin;"],
                filter_delay: 500
            });
            r.push({
                column_number: column_number++,
                filter_type: "range_number",
                filter_default_label: ["0", "100"],
                filter_delay: 500
            });
            r.push({
                column_number: column_number++,
                filter_type: "range_number",
                filter_default_label: ["0", "&infin;"],
                filter_delay: 500
            });
        } else if( columns[i].type == 'fc_tmp' || columns[i].type == 'fc_spt') {
            r.push( {
                column_number: column_number++,
                filter_type: "range_number",
                filter_default_label : ["-&infin;", "&infin;"],
                filter_delay: 500
            });
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
