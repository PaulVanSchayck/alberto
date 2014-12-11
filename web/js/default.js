

function defaultExperiment(root) {

    return function() {
        var publics = {};
        var $root = $(root);
        var scale = window.alberto.scale($root);
        var table = window.alberto.table($root, buildDTColumns());

        function load() {
            table.dt.ajax.reload();
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

        // Public functions and variables
        publics.load = load;

        return publics
    }();
}
