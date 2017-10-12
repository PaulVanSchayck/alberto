
function intactExperiment(experimentName, rules, images, columns, scales) {

    return function() {
        var tissues = [
            'inner-lower-tier',
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

        var table = window.alberto.table($("#" + experimentName + "-table"), buildDTColumns(columns), buildFilterColumns(columns), experimentName);
        var root = "#" + experimentName;
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
        }, [-1,1]);
        var svg = window.alberto.svg($root, tissues);

        function loadExperiment() {
            // SVG images
            $.each( images, function( name, selector )  {
                var ele = d3.select(root + " " + selector);
                svg.setupTooltip(ele, formatTooltip);
            });

            // TODO: This does not retrieve basecolor for all tissues
            baseColors = svg.retrieveFillColor(d3.select(root + " .lg"));

            // Poor mans method of injecting code into DataTables api
            table.dt.colvis = colvis($("#" + experimentName + "-visibilityModal"), table.dt);

            $root.find(".mode button").tooltip({placement: 'bottom', container: 'body'});

            $root.find(".warning-sign").tooltip({placement: 'right', title: formatWarningTooltip});

            $root.find(".gene-information .non-selected").tooltip({placement: 'bottom'});
            $root.find(".scale label").tooltip({placement: 'bottom'});

            $root.find(".mode button").click(function () {
                var $this = $(this);

                if ($this.hasClass('dropdown-toggle')) {
                    // Dropdowns are handled in another event handler
                    return;
                }

                navInfo.setExperimentMode($(this).data('mode'));
            });

            $root.find(".mode button.dropdown-toggle").parent().find('a').on('click', function (e) {
                var $a = $(this);
                e.preventDefault();

                navInfo.setExperimentMode($a.data('mode'));
            });

            // If no mode is selected, set the absolute expression mode
            if (!navInfo.getExperimentMode()) {
                $root.find(".mode button").first().click();
            }

            window.alberto.exportModal($root, table, experimentName);

            $(window).trigger('experiment.loaded');

            var $dropdown = svg.actionDropdown();

            $dropdown.find('a').click(function (e) {
                e.preventDefault();
                $dropdown.hide();

                var tissue = $($dropdown.data('g')).attr('class').replace(' pointer-events', '');
                var stage = $($dropdown.data('g')).parents('svg').attr('class');
                var column, columnIdx;

                if (rules[stage][tissue]) {
                    column = rules[stage][tissue]
                } else {
                    column = rules[stage]['*']
                }

                if ($(this).hasClass('highest')) {
                    navInfo.setExperimentMode('abs');

                    yadcf.exResetAllFilters(table.dt);

                    columnIdx = table.dt.column(column.abs + ":name").index();

                    if (columnIdx == undefined) {
                        return false;
                    }

                    if ($(this).hasClass('rsd')) {
                        table.dt.column(columnIdx + 1).visible(true);
                        yadcf.exFilterColumn(table.dt, [[columnIdx + 1, {to: 50}]], true);
                    }

                    table.dt.order([columnIdx, 'desc']).draw();

                    return false;
                }

                if ($(this).hasClass('enriched')) {
                    navInfo.setExperimentMode('fc_spt');

                    columnIdx = table.dt.column(column.fc_spt + ":name").index();

                    if (columnIdx == undefined) {
                        return false;
                    }

                    yadcf.exResetAllFilters(table.dt, true);

                    var filter = [
                        [columnIdx, {from: 1}]
                    ];

                    if ($(this).hasClass('significant')) {
                        table.dt.column(columnIdx + 1).visible(true);
                        filter.push([columnIdx + 1, {to: 0.05}])
                    }

                    yadcf.exFilterColumn(table.dt, filter, true);

                    // Because the column index is changed when the visibility is changed, recalculate
                    columnIdx = table.dt.column(rules[stage][tissue].fc_spt + ":name").index();
                    table.dt.order([columnIdx, 'desc']).draw();

                    return false;
                }
            });

            $root.find(".clearfilters").click(function () {
                yadcf.exResetAllFilters(table.dt);
            });

            highlightColumns();
        }

        function updateTableColors(type) {
            table.$table.find("tbody tr.selected td.type_" + type)
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

        function updateColors(colorScale, useBaseColors) {
            $.each(tissues, function (i, tissue) {
                d3.selectAll(root + ' .' + tissue).transition().duration(1000).attr('fill', function (d) {
                    if ( useBaseColors ) {
                        return baseColors[i]
                    }
                    if (d) {
                        if (navInfo.getExperimentMode() == 'fc_spt') {
                            return colorScale.defined(d.fc_spt)
                        } else if (navInfo.getExperimentMode() == 'fc_tmp') {
                            return colorScale.defined(d.fc_tmp)
                        } else if (navInfo.getExperimentMode() == 'rel') {
                            return colorScale.defined(d.rel)
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

            $.each(rules, function (stageId, stage) {
                var stageData = [],
                    $warningSign = $root.find(".svg[data-stage=" + stageId + "] img.warning-sign").removeClass('abs fc_spt fc_tmp');

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
                        rel: parseRuleField(s.abs, data, '_rel'),
                        fc_spt: parseRuleField(s.fc_spt, data),
                        fc_spt_q: parseRuleField(s.fc_spt, data, '_q'),
                        fc_tmp: parseRuleField(s.fc_tmp, data),
                        fc_tmp_q: parseRuleField(s.fc_tmp, data, '_q')
                    };

                    $warningSign.addClass(
                        (stageData[j].rsd > rsdWarning ? 'abs ' : '') +
                        (stageData[j].fc_spt_q > qWarning ? 'fc_spt ' : '') +
                        (stageData[j].fc_tmp_q > qWarning ? 'fc_tmp ' : '')
                    );
                });

                svg.assignData(d3.select(root + " ." + stageId), stageData);
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
                $root.find("." + tissue)
                    .on('mouseover', function () {
                        var $g = $(this);
                        var tissue = $g.attr('class').replace(' pointer-events', '');
                        var stage = $g.parents('svg').attr('class');
                        var column, highlight;
                        var tissueRules = rules[stage][tissue] ? rules[stage][tissue] : rules[stage]['*'];

                        column = tissueRules[navInfo.getExperimentMode()];
                        var columnIdx = table.dt.column(column + ":name").index();

                        if (columnIdx) {
                            $(table.dt.column(columnIdx).nodes()).addClass('highlight');
                        }

                        // Extra highlight
                        if (tissueRules.highlight && tissueRules.highlight[navInfo.getExperimentMode()]) {
                                  d3.select(root + ' ' + tissueRules.highlight[navInfo.getExperimentMode()])
                                      .classed('highlight', true)
                                      .transition().style('opacity', 0.5);
                        }
                    })
                    .on('mouseout', function () {
                        $(table.dt.cells().nodes()).removeClass('highlight');
                        d3.select(".highlight").classed('highlight', false).transition().style('opacity', 1);
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
                r += "<p class='sd'><span class='label label-primary'>Standard Deviation</span> " + d.sd + "</p>";

                warning = d.rsd > rsdWarning ? 'warning' : '';
                r += "<p class='sd " + warning + "'><span class='label label-primary'>%RSD</span> " + (d.rsd.toFixed ? d.rsd.toFixed(1) + "%" : d.rsd) + "</p>";
            }

            if (navInfo.getExperimentMode() == "rel") {
                r += "<p><span class='label label-primary'>Expression value</span> " + d.rel + "</p>";
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

            $root.css('opacity', 0.2);

            table.dt.one('draw.dt', function () {
                yadcf.exFilterColumn(table.dt, [[0, gene]], true);

                table.dt.one('draw.dt', function() {
                    $root.css('opacity', 1);
                    if (table.dt.data().length > 0) {
                        table.$table.find("tbody tr:eq(0)").addClass("selected");
                        showGene(gene);
                    } else {
                        noGeneFound();
                        unShowGene();
                    }
                });
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
                    .setAttribute('max', scales.abs.max[1])
                    .setValue([scales.abs.default[0], scales.abs.default[1]])
                    .refresh();

                scale.scale.domain([scales.abs.default[0], scales.abs.default[1]])
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
            } else if (navInfo.getExperimentMode() == "rel") {
                scale.slider.setAttribute('min', -10)
                    .setAttribute('max', 10)
                    .setValue([-5, 5])
                    .refresh();

                $root.find('.relative').append($("#relative-input").show());

                scale.scale.domain([-5, 0, 0, 5])
                    .range(["blue", "lightgray", "lightgray", "red"]);
                scale.setFcMode(true)
            }

            $root.removeClass('abs fc_spt fc_tmp rel').addClass(navInfo.getExperimentMode());
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
                        orderSequence: ['desc', 'asc']
                    });
                    r.push({
                        data: columns[i].field + '_sd',
                        name: columns[i].field + '_sd',
                        'class': 'type_sd',
                        orderSequence: ['desc', 'asc']
                    });
                    r.push({
                        data: columns[i].field + '_rel',
                        name: columns[i].field + '_rel',
                        'class': 'type_rel',
                        orderSequence: ['desc', 'asc']
                    });
                } else if (columns[i].type == 'fc_tmp' || columns[i].type == 'fc_spt') {
                    r.push({
                        data: columns[i].field + '_q',
                        name: columns[i].field + '_q',
                        render: function (data) {
                            if (data > qWarning) {
                                return "<span class='q-warning'>" + data + " </span>";
                            } else {
                                return data;
                            }
                        },
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