

function mpExperiment(experimentName,  rules, images, columns) {

    return function() {
        var publics = {};
        var root = "#" + experimentName;
        var $root = $(root);

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
            'columella',
            'unspecified',
            'primordia'
        ];

        var scale = window.alberto.scale(root, function(scale) {
            // What to do upon changing scale
            if( navInfo.getGene() ) {
                updateColors(scale);
                updateTableColors(navInfo.getExperimentMode());
            }
        }, [0,0]);
        var table = window.alberto.table($("#" + experimentName + "-table"), buildDTColumns(columns), buildFilterColumns(columns), experimentName);
        var svg = window.alberto.svg($root, tissues);
        var baseColors;

        function load() {
            // SVG images
            $.each( images, function( name, image )  {
                var ele = d3.select(root + " " + image.selector);
                svg.setupTooltip(ele, formatTooltip);

                if ( ! baseColors ) {
                    baseColors = svg.retrieveFillColor(ele);
                }
            });

            $root.find(".mode button").tooltip({placement: 'bottom', container: 'body'});
            $root.find(".gene-information .non-selected").tooltip({placement: 'bottom'});
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

            var $dropdown = svg.actionDropdown();

            $dropdown.find('a').click(function (e) {
                e.preventDefault();
                $dropdown.hide();

                var stage = $($dropdown.data('g')).parents('div').data('stage');
                var column;

                column = rules[stage]['*'].fc;

                var columnIdx = table.dt.column(column + ":name").index();

                if (columnIdx == undefined) {
                    return false;
                }

                yadcf.exResetAllFilters(table.dt, true);

                // Show q-value column
                table.dt.column(columnIdx + 1).visible(true);

                if ($(this).hasClass('up')) {
                    yadcf.exFilterColumn(table.dt, [[columnIdx, {from: 0}]], true);
                    table.dt.order([columnIdx, 'desc']);
                }

                if ($(this).hasClass('down')) {
                    yadcf.exFilterColumn(table.dt, [[columnIdx, {to: 0}]], true);
                    table.dt.order([columnIdx, 'asc']);
                }

                return false;

            });

            highlightColumns();

            $(window).trigger('experiment.loaded');
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

        function loadData(data) {

            $.each(rules, function (stageId, stage) {
                var stageData = [];

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
                        fc: parseRuleField(s.fc, data),
                        fc_q: parseRuleField(s.fc, data, '_q')
                    };

                });

                svg.assignData(d3.select(root + " " + images[stageId].selector), stageData);
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

        function formatTooltip(d) {
            var r;

            r = "<p><span class='label label-success'>Tissue</span> " + d.name + " </p>";

            if (navInfo.getExperimentMode() == "abs") {
                r += "<p><span class='label label-primary'>Expression value</span> " + d.abs + "</p>";
            }

            if (navInfo.getExperimentMode() == "fc" && d.fc) {
                r += "<p><span class='label label-primary'>FC</span> " + d.fc + "</p>";
                r += "<p><span class='label label-primary'>q-value</span> " + d.fc_q + "</p>";
            }

            r += "<p>Click tissue for actions</p>";

            return r;
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
                            return "<span class='gene-tooltip' data-toggle='tooltip' title='" + data + "'>" + data.substr(0, 20) + " </span>";
                        } else {
                            return "";
                        }
                    },
                    name: 'gene.annotation',
                    'class': 'type_ann'
                },
                {data: 'splice', 'class': 'type_ann', name: 'splice'}
            ];

            for (var i = 0; i < columns.length; i++) {
                r.push({
                    data: columns[i].field,
                    name: columns[i].field,
                    'class': 'type_' + columns[i].type,
                    orderSequence: ['desc', 'asc']
                });
                r.push({
                    data: columns[i].field + '_q',
                    name: columns[i].field + '_q',
                    'class': 'type_' + columns[i].type + '_q',
                    orderSequence: ['desc', 'asc']
                });
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
                },
                {
                    column_number: column_number++,
                    filter_type: "text",
                    filter_delay: 500
                }

            ];

            for (var i = 0; i < columns.length; i++) {
                if ( columns[i].type == 'fc') {
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
                }
            }

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

        function showGene() {
            var $row = table.getSelectedRow();

            var data = table.dt.row($row).data();

            updateTableColors(navInfo.getExperimentMode());

            showGeneInformation($root, data);
            loadData(data);
        }

        function modeChanged() {
            if (navInfo.getExperimentMode() == "fc") {
                scale.slider.setAttribute('min', -10)
                    .setAttribute('max', 10)
                    .setValue([-5, 5])
                    .refresh();

                scale.scale.domain([-5, 0, 0, 5])
                    .range(["blue", "lightgray", "lightgray", "red"]);
                scale.setFcMode(true)
            } else if (navInfo.getExperimentMode() == "abs") {
                scale.slider.setAttribute('min', 0)
                    .setAttribute('max', 200)
                    .setValue([32, 100])
                    .refresh();

                scale.scale.domain([32, 100])
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
