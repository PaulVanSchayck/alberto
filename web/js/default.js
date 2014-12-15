

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

        function load() {
            $(window).trigger('experiment.loaded');

            // SVG images
            var wtlg = d3.select('#mpproper .wt .lg');
            var mplg = d3.select('#mpproper .mp .lg');
            var wths = d3.select('#mpproper .wt .hs');
            var mphs = d3.select('#mpproper .mp .hs');

            baseColors = svg.retrieveFillColor(wths);

            svg.setupTooltip(wtlg, formatTooltip);
            svg.setupWarningTooltip(wtlg, formatWarningTooltip);
            svg.setupTooltip(mplg, formatTooltip);
            svg.setupWarningTooltip(mplg, formatWarningTooltip);
            svg.setupTooltip(wths, formatTooltip);
            svg.setupWarningTooltip(wths, formatWarningTooltip);
            svg.setupTooltip(mphs, formatTooltip);
            svg.setupWarningTooltip(mphs, formatWarningTooltip);

            scale.slider.setAttribute('min', 0)
                .setAttribute('max', 200)
                .setValue([32, 100])
                .refresh();

            scale.scale.domain([32, 100])
                .range(["yellow", "red"]);

            scale.showScale();
        }

        function loadData(data) {

            $.each(mpRules, function (stageId, stage) {
                var stageData = [], warning = {'abs': false };

                d3.select(root + " ." + stageId + " g.warning-sign").classed(warning);

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

                d3.select(root + " ." + stageId + " g.warning-sign").classed(warning);

                svg.assignData(d3.select(root + " ." + stageId), stageData);
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
