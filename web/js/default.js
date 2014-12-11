

function defaultExperiment(root) {

    return function() {
        var publics = {};
        var $root = $(root);
        var scale = window.alberto.scale($root);

        function load() {

        }

        // Public functions
        publics.load = load;

        return publics
    }();
}
