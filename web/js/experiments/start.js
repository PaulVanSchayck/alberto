/**
 * This function offers a no experiment default, for the start and help page
 */

function noExperiment() {

    return function () {
        var publics = {};

        function load() {

        }

        function showGene() {

        }

        function unShowGene() {

        }

        function filterGene() {
            $("#select-experiment").show()
        }

        function reloadTable() {

        }

        // Public functions and variables
        publics.load = load;
        publics.showGene = showGene;
        publics.unShowGene = unShowGene;
        publics.filterGene = filterGene;
        publics.reloadTable = reloadTable;

        return publics;
    }()
}


