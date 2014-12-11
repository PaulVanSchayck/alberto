

function defaultExperiment(root) {

    return function() {
        var publics = {};
        var $root = $(root);

        function load() {
            var slider = $root.find(".scale-slider")
                .slider({tooltip: 'always'})
                .on('slide', function() {
                    // Eval is evil??
                    var domain = eval( '[' + slider.getValue() + ']');

                    scale.domain(domain);

                    if( navInfo.getGene() ) {
                        updateColors(scale);
                        updateTableColors(navInfo.getMode());
                    }
                }).data('slider').disable();

            $root.find(".scale-input").change(function() {
                if ( $(this).is(":checked") ) {
                    slider.enable()
                } else {
                    slider.disable()
                }
            });
        }

        // Public functions
        publics.load = load;

        return publics
    }();
}
