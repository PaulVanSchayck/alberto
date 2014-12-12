

function defaultExperiment(root) {

    return function() {
        var publics = {};
        var $root = $(root);
        var scale = window.alberto.scale($root);
        var table = window.alberto.table($("#mpTable"), buildDTColumns(), buildFilterColumns());

        function load() {
            $(window).trigger('experiment.loaded');
        }

        function buildDTColumns() {
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

            return r;
        }

        function buildFilterColumns() {
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
        }

        // Public functions and variables
        publics.load = load;
        publics.showGene = showGene;
        publics.filterGene = filterGene;
        publics.reloadTable = table.dt.ajax.reload;

        return publics
    }();
}
