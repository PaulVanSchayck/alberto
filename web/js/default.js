

function defaultExperiment(root) {

    return function() {
        var publics = {};
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
            'columella'
        ];

        var scale = window.alberto.scale(root, function(scale) {
            // What to do upon changing scale
            if( navInfo.getGene() ) {
                updateColors(scale);
                updateTableColors(navInfo.getMode());
            }
        });
        var table = window.alberto.table($("#mpTable"), buildDTColumns(mpColumns), buildFilterColumns(mpColumns), 'mpproper');
        var svg = window.alberto.svg($root, tissues);
        var baseColors = svg.retrieveFillColor(d3.select(root + " " + mpImages[0]));

        function load() {
            // SVG images
            $.each( mpImages, function( name, selector )  {
                var ele = d3.select(root + " " + selector);
                svg.setupTooltip(ele, formatTooltip);
                svg.setupWarningTooltip(ele, formatWarningTooltip);
            });

            $root.find(".mode button").tooltip({placement: 'bottom', container: 'body'});

            $root.find(".gene-information .non-selected").tooltip({placement: 'bottom'});
            $root.find(".scale label").tooltip({placement: 'bottom'});

            $root.find(".mode button").click(function () {
                navInfo.setMode($(this).data('mode'));
            });

            // Poor mans method of injecting code into DataTables api
            table.dt.colvis = colvis($("#Q0990-visibilityModal"), table.dt);

            $(window).on('alberto.mode.changed', function () {
                if (navInfo.getMode() == "fc_spt") {
                    scale.slider.setAttribute('min', -10)
                        .setAttribute('max', 10)
                        .setValue([-5, 5])
                        .refresh();

                    scale.scale.domain([-5, -1, 1, 5])
                        .range(["green", "black", "black", "red"]);
                } else if (navInfo.getMode() == "abs") {
                    scale.slider.setAttribute('min', 0)
                        .setAttribute('max', 200)
                        .setValue([32, 100])
                        .refresh();

                    scale.scale.domain([32, 100])
                        .range(["yellow", "red"]);
                }

                $root.removeClass('abs fc_spt').addClass(navInfo.getMode());
                highlightActiveMode(navInfo.getMode());

                table.showColumnType(navInfo.getMode());
                scale.showScale();

                if (navInfo.getGene()) {
                    updateColors(scale.scale);
                    updateTableColors(navInfo.getMode());
                }
            });

            // If no mode is selected, set the absolute expression mode
            if (!navInfo.getMode()) {
                $root.find(".mode button").first().click();
            }

            $(window).trigger('experiment.loaded');
        }

        function loadData(data) {

            $.each(mpRules, function (stageId, stage) {
                var stageData = [], warning = {'abs': false };

                d3.select(root + " " + mpImages[stageId] + " g.warning-sign").classed(warning);

                $.each(tissues, function (j, tissue) {
                    var s;

                    if (stage[tissue] !== undefined) {
                        s = stage[tissue];
                    } else {
                        s = stage['*'];
                    }

                    stageData[j] = {
                        name: s.name,
                        abs: parseRuleField(s.abs, data)
                    };

                    warning = {
                        //'abs': stageData[j].rsd > rsdWarning && !warning.abs ? true : warning.abs
                    };
                });

                d3.select(root + " " + mpImages[stageId] + " g.warning-sign").classed(warning);

                svg.assignData(d3.select(root + " " + mpImages[stageId]), stageData);
            });

            updateColors(scale.scale);
        }

        function updateColors(colorScale, useIndex) {
            $.each(tissues, function (i, tissue) {
                d3.selectAll(root + ' .' + tissue).transition().duration(1000).attr('fill', function (d) {
                    if (!useIndex && d) {
                        return colorScale.defined(d.abs)
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

        function highlightActiveMode(mode) {
            $root.find(".mode button").removeClass('btn-primary');
            $root.find(".mode button[data-mode=" + mode + "]").addClass('btn-primary');
        }

        function formatWarningTooltip() {
            return "This tissue has issues"
        }

        function formatTooltip(d) {
            var r;

            r = "<p><span class='label label-success'>Tissue</span> " + d.name + " </p>";

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
                }
            }

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
                }
            });
        }

        function showGene() {
            var $row = table.getSelectedRow();

            var data = table.dt.row($row).data();

            updateTableColors(navInfo.getMode());

            showGeneInformation($root, data);
            loadData(data);
        }

        // Public functions and variables
        publics.load = load;
        publics.showGene = showGene;
        publics.filterGene = filterGene;
        publics.reloadTable = table.dt.ajax.reload;

        return publics
    }();
}
