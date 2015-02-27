function defaultExperiment(experimentName, rules, images, columns, scales) {

    return function() {
        var publics = {};
        var root = "#" + experimentName;
        var $root = $(root);
        var qWarning = 0.05;
        var rsdWarning = 50;

        var tissues = [
            'suspensor',
            'upper-tier',
            'lower-tier'
        ];

        var scale = window.alberto.scale(root, function(scale) {
            // What to do upon changing scale
            if( navInfo.getGene() ) {
                updateColors(scale);
                updateTableColors(navInfo.getExperimentMode());
            }
        }, [-1,1]);
        var table = window.alberto.table($("#" + experimentName + "-table"), buildDTColumns(columns), buildFilterColumns(columns), experimentName);
        var svg = window.alberto.svg($root, tissues);
        var baseColors;

        function load() {
            // SVG images
            $.each( images, function( name, selector )  {
                var ele = d3.select(root + " " + selector);
                svg.setupTooltip(ele, formatTooltip);

                if ( ! baseColors ) {
                    baseColors = svg.retrieveFillColor(ele);
                }
            });

            $root.find(".mode button").tooltip({placement: 'bottom', container: 'body'});

            $root.find(".gene-information .non-selected").tooltip({placement: 'bottom'});
            $root.find(".warning-sign").tooltip({placement: 'right', title: formatWarningTooltip});
            $root.find(".scale label").tooltip({placement: 'bottom'});

            $root.find(".mode button").click(function () {
                navInfo.setExperimentMode($(this).data('mode'));
            });

            // Poor mans method of injecting code into DataTables api
            table.dt.colvis = colvis($("#" + experimentName + "-visibilityModal"), table.dt);

            window.alberto.exportModal($root, table, experimentName);

            // If no mode is selected, set the absolute expression mode
            if (!navInfo.getExperimentMode()) {
                $root.find(".mode button").first().click();
            }

            $root.find(".clearfilters").click(function () {
                yadcf.exResetAllFilters(table.dt);
            });

            highlightColumns();

           var $dropdown = svg.actionDropdown();

            $dropdown.find('a').click(function (e) {
                e.preventDefault();
                $dropdown.hide();

                var column,
                    columnIdx,
                    filter = [],
                    $this = $(this);

                yadcf.exResetAllFilters(table.dt, true);

                if ( $this.hasClass('highest') ) {
                    var stage = $($dropdown.data('g')).parents('div').data('stage');
                    column = rules[stage]['*'].abs;
                    columnIdx = table.dt.column(column + ":name").index();

                    navInfo.setExperimentMode('abs');

                    table.dt.order([columnIdx, 'desc']).draw();

                    // Show rsd column
                    table.dt.column(columnIdx + 1).visible(true);

                    filter.push([columnIdx + 1, {to: 50}]);
                }

                if ( $this.hasClass('fc') ) {
                    column = rules['mt']['*'].fc;
                    columnIdx = table.dt.column(column + ":name").index();

                    navInfo.setExperimentMode('fc');

                    // Show q-value column
                    table.dt.column(columnIdx + 1).visible(true);

                    filter = [
                        [columnIdx + 1, {to: 0.05}]
                    ];

                    if ($this.hasClass('up')) {
                        filter.push([columnIdx, {from: 0}]);
                        table.dt.order([columnIdx, 'desc']);
                    }

                    if ($this.hasClass('down')) {
                        filter.push([columnIdx, {to: 0}]);
                        table.dt.order([columnIdx, 'asc']);
                    }
                }

                yadcf.exFilterColumn(table.dt, filter, true);

                return false;

            });

            $(window).trigger('experiment.loaded');
        }

        function loadData(data) {

            $.each(rules, function (stageId, stage) {
                var stageData = [],
                    $warningSign = $root.find(".svg[data-stage=" + stageId + "] img.warning-sign").removeClass('abs fc');

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
                        fc: parseRuleField(s.fc, data),
                        fc_q: parseRuleField(s.fc, data, '_q')
                    };

                    $warningSign.addClass(
                        (stageData[j].rsd > rsdWarning ? 'abs ' : '') +
                        (stageData[j].fc_q > qWarning ? 'fc ' : '')
                    );
                });

                svg.assignData(d3.select(root + " " + images[stageId]), stageData);
            });

            updateColors(scale.scale);
        }

        function updateColors(colorScale, useBaseColors) {
            $.each(tissues, function (i, tissue) {
                d3.selectAll(root + ' .' + tissue).transition().duration(1000).attr('fill', function (d) {
                    if ( useBaseColors ) {
                        return baseColors[i]
                    }
                    if (d) {
                        if (navInfo.getExperimentMode() == 'fc') {
                            return colorScale.defined(d.fc)
                        } else if (navInfo.getExperimentMode() == 'abs') {
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

        function updateTableColors(type) {
            table.$table.find("tbody tr.selected td.type_" + type)
                .css('background-color', function () {
                    return scale.scale.defined($(this).html())
                })
                .css('color', function () {
                    // Find contrasting color
                    // From: http://ux.stackexchange.com/questions/8297/choosing-high-contrast-text-color-in-relation-to-background-color-dynamically
                    var c = d3.rgb(scale.scale.defined($(this).html()));

                    var y = 0.2126 * Math.pow(c.r / 255, 2.2) + 0.7151 * Math.pow(c.g / 255, 2.2) + 0.0721 * Math.pow(c.b / 255, 2.2);

                    if (y > 0.25) {
                        return 'black';
                    } else {
                        return 'white'
                    }
                });
        }

        function highlightActiveMode(mode) {
            $root.find(".mode button").removeClass('btn-primary');
            $root.find(".mode button[data-mode=" + mode + "]").addClass('btn-primary');
        }

        function formatWarningTooltip() {
            if (navInfo.getExperimentMode() == 'abs') {
                return 'A tissue in this embryo has a relative standard deviation above 50%'
            } else {
                return 'A fold change in this embryo has a q-value above 0.05'
            }
        }

        function formatTooltip(d) {
            var r;

            r = "<p><span class='label label-success'>Tissue</span> " + d.name + " </p>";

            if (navInfo.getExperimentMode() == "abs") {
                r += "<p><span class='label label-primary'>Expression value</span> " + d.abs + "</p>";
                r += "<p class='sd'><span class='label label-primary'>Standard Deviation</span> " + d.sd + "</p>";

                warning = d.rsd > rsdWarning ? 'warning' : '';
                r += "<p class='sd " + warning + "'><span class='label label-primary'>%RSD</span> " + (d.rsd.toFixed ? d.rsd.toFixed(1) + "%" : d.rsd) + "</p>";
            }

            if (navInfo.getExperimentMode() == "fc" && d.fc) {
                r += "<p><span class='label label-primary'>FC</span> " + d.fc + "</p>";

                warning = d.fc_q > qWarning ? 'warning' : '';
                r += "<p class='q " + warning + "'><span class='label label-primary'>q-value</span> " + d.fc_q + "</p>";
            }

            r += "<p>Click tissue for actions</p>";

            return r;
        }

        function highlightColumns() {

            $.each(tissues, function (i, tissue) {
                $root.find("." + tissue)
                    .on('mouseover', function () {
                        var $g = $(this);
                        var tissue = $g.attr('class').replace(' pointer-events', '');
                        var stage = $g.parents('div.svg').data('stage');
                        var column;

                        if (rules[stage][tissue]) {
                            column = rules[stage][tissue][navInfo.getExperimentMode()]
                        } else {
                            column = rules[stage]['*'][navInfo.getExperimentMode()]
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
                }
                if ( columns[i].type == 'fc') {
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
                } else if ( columns[i].type == 'fc') {
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

        function filterGene(gene) {
            yadcf.exResetAllFilters(table.dt, true);

            table.dt.one('draw.dt', function () {
                yadcf.exFilterColumn(table.dt, [[0, gene]], true);

                table.dt.one('draw.dt', function() {

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

        function showGene() {
            var $row = table.getSelectedRow();

            var data = table.dt.row($row).data();

            updateTableColors(navInfo.getExperimentMode());

            showGeneInformation($root, data);
            loadData(data);
        }

        function modeChanged() {
            if (navInfo.getExperimentMode() == "fc") {
                scale.slider.setAttribute('min', scales.fc.max[0])
                    .setAttribute('max', scales.fc.max[1])
                    .setValue([scales.fc.default[0], scales.fc.default[1]])
                    .refresh();

                scale.scale.domain([scales.fc.default[0], -1, 1, scales.fc.default[1]])
                    .range(["blue", "lightgray", "lightgray", "red"]);
                scale.setFcMode(true)
            } else if (navInfo.getExperimentMode() == "abs") {
                scale.slider.setAttribute('min', scales.abs.max[0])
                    .setAttribute('max', scales.abs.max[1])
                    .setValue([scales.abs.default[0], scales.abs.default[1]])
                    .refresh();

                scale.scale.domain([scales.abs.default[0], scales.abs.default[1]])
                    .range(["yellow", "red"]);
                scale.setFcMode(false)
            }

            $root.removeClass('abs fc').addClass(navInfo.getExperimentMode());
            highlightActiveMode(navInfo.getExperimentMode());

            table.showColumnType(navInfo.getExperimentMode());
            scale.showScale();

            if (navInfo.getGene()) {
                updateColors(scale.scale);
                updateTableColors(navInfo.getExperimentMode());
            }
        }

        function unShowGene() {
            // Revert to base colors
            updateColors(baseColors, true);

            hideGeneInformation($root);

            $root.find("tbody tr.selected").removeClass("selected").find('td').css('background-color', '').css('color', '');
        }

        // Public functions and variables
        publics.load = load;
        publics.showGene = showGene;
        publics.unShowGene = unShowGene;
        publics.filterGene = filterGene;
        publics.modeChanged = modeChanged;
        publics.reloadTable = table.dt.ajax.reload;

        return publics
    }();
}
