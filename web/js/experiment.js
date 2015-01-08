
function intactExperiment(root) {

    return function() {
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

        var table = window.alberto.table($("#intactTable"), buildDTColumns(intactColumns), buildFilterColumns(intactColumns), 'intact');
        var baseColors;

        var rsdWarning = 50;
        var qWarning = 0.05;

        var $root = $(root);
        var scale= window.alberto.scale(root, function(scale) {
            // What to do upon changing scale
            if( navInfo.getGene() ) {
                updateColors(scale);
                updateTableColors(navInfo.getExperimentMode());
            }
        });
        var svg = window.alberto.svg($root, tissues);

        function loadExperiment() {
            // SVG images
            var lg = d3.select('#intact .lg');
            var eg = d3.select('#intact .eg');
            var hs = d3.select('#intact .hs');

            baseColors = svg.retrieveFillColor(hs);

            svg.setupTooltip(eg, formatTooltip);
            svg.setupWarningTooltip(eg, formatWarningTooltip);
            svg.setupTooltip(lg, formatTooltip);
            svg.setupWarningTooltip(lg, formatWarningTooltip);
            svg.setupTooltip(hs, formatTooltip);
            svg.setupWarningTooltip(hs, formatWarningTooltip);

            // Poor mans method of injecting code into DataTables api
            table.dt.colvis = colvis($("#visibilityModal"), table.dt);

            $("#intact .mode button").tooltip({placement: 'bottom', container: 'body'});

            $("#intact .gene-information .non-selected").tooltip({placement: 'bottom'});
            $("#intact .scale label").tooltip({placement: 'bottom'});

            $("#intact .mode button").click(function () {
                var $this = $(this);

                if ($this.hasClass('dropdown-toggle')) {
                    // Dropdowns are handled in another event handler
                    return;
                }

                navInfo.setExperimentMode($(this).data('mode'));
            });

            $("#intact .mode button.dropdown-toggle").parent().find('a').on('click', function (e) {
                var $a = $(this);
                e.preventDefault();

                navInfo.setExperimentMode($a.data('mode'));
            });

            // If no mode is selected, set the absolute expression mode
            if (!navInfo.getExperimentMode()) {
                $root.find(".mode button").first().click();
            }

            window.alberto.exportModal($root, table, 'intact');

            $(window).trigger('experiment.loaded');

            var $dropdown = $('.dropdown-menu.actions');
            $('div.svg svg g').click(function (e) {

                $dropdown
                    .fadeIn()
                    .offset({left: e.pageX, top: e.pageY});

                $dropdown.data('g', this);

                $(document).one('mouseup', function (e) {
                    if (!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) {
                        $dropdown.hide();
                    }
                });

                event.stopPropagation();
            });

            $dropdown.find('a').click(function (e) {
                e.preventDefault();
                $dropdown.hide();

                var tissue = $($dropdown.data('g')).attr('class');
                var stage = $($dropdown.data('g')).parents('svg').attr('class');
                var column;

                if (intactRules[stage][tissue]) {
                    column = intactRules[stage][tissue].abs
                } else {
                    column = intactRules[stage]['*'].abs
                }
                var columnIdx = table.dt.column(column + ":name").index();

                if (columnIdx == undefined) {
                    return false;
                }

                if ($(this).hasClass('highest')) {
                    navInfo.setExperimentMode('abs');

                    table.dt.order([columnIdx, 'desc']);
                    yadcf.exResetAllFilters(table.dt);
                    yadcf.exFilterColumn(table.dt, [[columnIdx, {from: 100}]], true);

                    return false;
                }

                if ($(this).hasClass('not-expressed')) {
                    navInfo.setExperimentMode('abs');

                    table.dt.order([columnIdx, 'asc']);
                    yadcf.exResetAllFilters(table.dt);
                    yadcf.exFilterColumn(table.dt, [[columnIdx, {to: 32}]], true);

                    return false;
                }

                if ($(this).hasClass('enriched')) {
                    navInfo.setExperimentMode('fc_spt');

                    columnIdx = table.dt.column(intactRules[stage][tissue].fc_spt + ":name").index();

                    yadcf.exResetAllFilters(table.dt, true);

                    var filter = [
                        [columnIdx, {from: 2}]
                    ];

                    if ($(this).hasClass('significant')) {
                        table.dt.column(columnIdx + 1).visible(true);
                        filter.push([columnIdx + 1, {to: 0.05}])
                    }

                    yadcf.exFilterColumn(table.dt, filter, true);

                    table.dt.order([columnIdx, 'desc']);

                    return false;
                }
            });

            $root.find(".clearfilters").click(function () {
                yadcf.exResetAllFilters(table.dt);
            });

            highlightColumns();
        }

        function updateTableColors(type) {
            $("#intactTable tbody tr.selected td.type_" + type)
                .css('background-color', function () {
                    return scale.scale($(this).html())
                })
                .css('color', function () {
                    // Find contrasting color
                    // From: http://ux.stackexchange.com/questions/8297/choosing-high-contrast-text-color-in-relation-to-background-color-dynamically
                    var c = d3.rgb(scale.scale($(this).html()));

                    var y = 0.2126 * Math.pow(c.r / 255, 2.2) + 0.7151 * Math.pow(c.g / 255, 2.2) + 0.0721 * Math.pow(c.b / 255, 2.2);

                    if (y > 0.25) {
                        return 'black';
                    } else {
                        return 'white'
                    }
                });
        }

        function updateColors(colorScale, useIndex) {
            $.each(tissues, function (i, tissue) {
                d3.selectAll('#intact .' + tissue).transition().duration(1000).attr('fill', function (d) {
                    if (!useIndex && d) {

                        if (navInfo.getExperimentMode() == 'fc_spt') {
                            return colorScale.defined(d.fc_spt)
                        } else if (navInfo.getExperimentMode() == 'fc_tmp') {
                            return colorScale.defined(d.fc_tmp)
                        } else {
                            return colorScale.defined(d.abs)
                        }
                    } else {
                        return colorScale(i)
                    }
                }).each('start', function () {
                    d3.select(this).attr('in-transition', 'yes')
                }).each('end', function () {
                    d3.select(this).attr('in-transition', 'no')
                })
            });
        }

        function loadINTACT(data) {

            $.each(intactRules, function (stageId, stage) {
                var stageData = [], warning = {'abs': false, 'fc_spt': false, 'fc_tmp': false};

                d3.select("#intact ." + stageId + " g.warning-sign").classed(warning);

                $.each(tissues, function (j, tissue) {
                    var s;

                    if (stage[tissue] !== undefined) {
                        s = stage[tissue];
                    } else {
                        s = stage['*'];
                    }

                    stageData[j] = {
                        name: s.name,
                        abs: parseRuleField(s.abs, data),
                        sd: parseRuleField(s.abs, data, '_sd'),
                        rsd: parseRuleField(s.abs, data, '_rsd'),
                        fc_spt: parseRuleField(s.fc_spt, data),
                        fc_spt_q: parseRuleField(s.fc_spt, data, '_q'),
                        fc_tmp: parseRuleField(s.fc_tmp, data),
                        fc_tmp_q: parseRuleField(s.fc_tmp, data, '_q')
                    };

                    warning = {
                        'abs': stageData[j].rsd > rsdWarning && !warning.abs ? true : warning.abs,
                        'fc_spt': stageData[j].fc_spt_q > qWarning && !warning.fc_spt ? true : warning.fc_spt,
                        'fc_tmp': stageData[j].fc_tmp_q > qWarning && !warning.fc_tmp ? true : warning.fc_tmp
                    };
                });

                d3.select("#intact ." + stageId + " g.warning-sign").classed(warning);

                svg.assignData(d3.select("#intact ." + stageId), stageData);
            });

            updateColors(scale.scale);
        }

        function highlightActiveMode(mode) {
            $root.find(".mode button").removeClass('btn-primary');
            $root.find(".mode li").removeClass('active');

            $root.find(".mode button[data-mode=" + mode + "]").addClass('btn-primary');

            $root.find(".mode li a[data-mode=" + mode + "]")
                .closest('li').addClass('active')
                .closest('div').find('button').addClass('btn-primary');
        }

        function highlightColumns() {

            $.each(tissues, function (i, tissue) {
                $("." + tissue)
                    .on('mouseover', function () {
                        var $g = $(this);
                        var tissue = $g.attr('class');
                        var stage = $g.parents('svg').attr('class');
                        var column;

                        if (intactRules[stage][tissue]) {
                            column = intactRules[stage][tissue][navInfo.getExperimentMode()]
                        } else {
                            column = intactRules[stage]['*'][navInfo.getExperimentMode()]
                        }
                        var columnIdx = table.dt.column(column + ":name").index();

                        if (columnIdx) {
                            $(table.dt.column(columnIdx).nodes()).addClass('highlight');
                        }
                    })
                    .on('mouseout', function () {
                        $(table.dt.cells().nodes()).removeClass('highlight')
                    })
            });
        }

        function formatWarningTooltip() {
            if (navInfo.getExperimentMode() == 'abs') {
                return 'A tissue in this embryo has a relative standard deviation above 50%'
            } else {
                return 'A fold change in this embryo has a q-value above 0.05'
            }
        }

        function formatTooltip(d) {
            var r, warning;

            r = "<p><span class='label label-success'>Tissue</span> " + d.name + " </p>";

            if (navInfo.getExperimentMode() == "abs") {
                r += "<p><span class='label label-primary'>Expression value</span> " + d.abs + "</p>";
                warning = d.rsd > rsdWarning ? 'warning' : '';
                r += "<p class='sd " + warning + "'><span class='label label-primary'>Standard deviation</span> " + d.sd + "</p>";
                r += "<p class='sd " + warning + "'><span class='label label-primary'>%RSD</span> " + (d.rsd.toFixed ? d.rsd.toFixed(1) + "%" : d.rsd) + "</p>";
            }

            if (navInfo.getExperimentMode() == "fc_spt" && d.fc_spt) {
                warning = d.fc_spt_q > qWarning ? 'warning' : '';
                r += "<p><span class='label label-primary'>Spatial FC</span> " + d.fc_spt + "</p>";
                r += "<p class='q " + warning + "'><span class='label label-primary'>q-value</span> " + d.fc_spt_q + "</p>";
            }

            if (navInfo.getExperimentMode() == "fc_tmp" && d.fc_tmp) {
                warning = d.fc_tmp_q > qWarning ? 'warning' : '';
                r += "<p><span class='label label-primary'>Temporal FC</span> " + d.fc_tmp + "</p>";
                r += "<p class='q " + warning + "'><span class='label label-primary'>q-value</span> " + d.fc_tmp_q + "</p>";
            }

            r += "<p>Click tissue for actions</p>";

            return r;
        }

        function filterGene(gene) {
            yadcf.exResetAllFilters(table.dt, true);
            yadcf.exFilterColumn(table.dt, [[0, gene]], true);

            table.dt.one('draw.dt', function () {
                if (table.dt.data().length > 0) {
                    table.$table.find("tbody tr:eq(0)").addClass("selected");
                    showGene(gene);
                } else {
                    $("#no-results").show();
                    unShowGene();
                }
            });
        }

        function unShowGene() {
            // Revert to base colors
            updateColors(baseColors, true);

            hideGeneInformation($root);

            $root.find("tbody tr.selected").removeClass("selected").find('td').css('background-color', '').css('color', '');
        }

        function showGene() {
            var $row = table.getSelectedRow();

            updateTableColors(navInfo.getExperimentMode());

            var data = table.dt.row($row).data();

            loadINTACT(data);
            showGeneInformation($root, data);
        }

        function modeChanged() {
            if (navInfo.getExperimentMode() == "fc_spt") {
                scale.slider.setAttribute('min', -10)
                    .setAttribute('max', 10)
                    .setValue([-5, 5])
                    .refresh();

                scale.scale.domain([-5, -1, 1, 5])
                    .range(["blue", "lightgray", "lightgray", "red"]);
                scale.setFcMode(true);
            } else if (navInfo.getExperimentMode() == "abs") {
                scale.slider.setAttribute('min', 0)
                    .setAttribute('max', 200)
                    .setValue([32, 100])
                    .refresh();

                scale.scale.domain([32, 100])
                    .range(["yellow", "red"]);
                scale.setFcMode(false);
            } else if (navInfo.getExperimentMode() == "fc_tmp") {
                scale.slider.setAttribute('min', -10)
                    .setAttribute('max', 10)
                    .setValue([-5, 5])
                    .refresh();

                scale.scale.domain([-5, -1, 1, 5])
                    .range(["blue", "lightgray", "lightgray", "red"]);
                scale.setFcMode(true)
            }

            $("#intact").removeClass('abs fc_spt fc_tmp').addClass(navInfo.getExperimentMode());
            highlightActiveMode(navInfo.getExperimentMode());

            table.showColumnType(navInfo.getExperimentMode());
            scale.showScale();

            if (navInfo.getGene()) {
                updateColors(scale.scale);
                updateTableColors(navInfo.getExperimentMode());
            }
        }

        function buildDTColumns(columns) {
            var r = [
                {data: 'gene_agi', 'class': 'type_ann', name: 'gene_agi'},
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

            for (var i = 0; i < columns.length; i++) {
                r.push({
                    data: columns[i].field,
                    name: columns[i].field,
                    'class': 'type_' + columns[i].type,
                    orderSequence: ['desc', 'asc']
                });

                if (columns[i].type == 'abs') {
                    r.push({
                        data: columns[i].field + '_rsd',
                        name: columns[i].field + '_rsd',
                        render: function (data) {
                            if (data > rsdWarning) {
                                return "<span class='sd-warning'>" + data.toFixed(1) + " </span>";
                            } else {
                                return data.toFixed(1);
                            }
                        },
                        'class': 'type_rsd',
                        visible: true,
                        orderSequence: ['desc', 'asc']
                    });
                    r.push({
                        data: columns[i].field + '_sd',
                        name: columns[i].field + '_sd',
                        'class': 'type_sd',
                        visible: true,
                        orderSequence: ['desc', 'asc']
                    });
                } else if (columns[i].type == 'fc_tmp' || columns[i].type == 'fc_spt') {
                    r.push({
                        data: columns[i].field + '_q',
                        name: columns[i].field + '_q',
                        visible: true,
                        orderSequence: ['desc', 'asc']
                    });
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

            for (var i = 0; i < columns.length; i++) {
                if (columns[i].type == 'abs') {
                    r.push({
                        column_number: column_number++,
                        filter_type: "range_number",
                        filter_default_label: ["0", "&infin;"],
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
                } else if (columns[i].type == 'fc_tmp' || columns[i].type == 'fc_spt') {
                    r.push({
                        column_number: column_number++,
                        filter_type: "range_number",
                        filter_default_label: ["-&infin;", "&infin;"],
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

        // Public functions exposed for this experiment
        return {
            load: loadExperiment,
            reloadTable: table.dt.ajax.reload,
            showGene: showGene,
            unShowGene: unShowGene,
            filterGene: filterGene,
            modeChanged: modeChanged
        }
    }()
}