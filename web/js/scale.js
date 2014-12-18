/**
 * Functions for controlling the scale and the slider associated with it
 */

window.alberto.scale = function scale(root, changeScaleCallback) {
    var scale = d3.scale.linear();

    var $root = $(root);
    /**
     * This wraps the scale function, in order to return white whenever false or undefined is requested
     *
     * @param n
     * @returns {*}
     */
    scale.defined = function(n) {
        if ( n === false ) {
            return "#FFFFFF"
        } else if( n == 'no-data' ) {
            return "lightgray"
        } else {
            return this(n);
        }
    };

    var slider = $root.find(".scale-slider")
        .slider({tooltip: 'always'})
        .on('slide', function() {
            // Eval is evil??
            var domain = eval( '[' + slider.getValue() + ']');

            scale.domain(domain);

            changeScaleCallback(scale)
        }).data('slider').disable();

    $root.find(".scale-input").change(function() {
        if ( $(this).is(":checked") ) {
            slider.enable()
        } else {
            slider.disable()
        }
    });

    // Allow to change scale through clicking badge
    $root.find(".scale").on('click', '.badge', function() {
        if ( !$root.find(".scale-input").is(':checked') ) {
            return false;
        }
        var $this = $(this);
        var val = $this.text();
        var $input = $('<input class="scale-domain" value=' + val + '>').on('change, focusout', function() {
            var attr, $this = $(this);

            if ( ! $.isNumeric($this.val()) ) {
                return false;
            }

            if ( $this.prevAll('.slider').length !== 0 ) {
                attr = 'max'
            } else {
                attr = 'min'
            }

            // Refresh slider and the scale through triggering a slide event
            slider.setAttribute(attr, parseInt($this.val())).refresh();
            $root.find(".scale-slider").trigger('slide');

            $this.replaceWith('<b class="badge">' + $this.val() + '</b>');
        });
        $this.replaceWith($input);
        $input.focus()
    });

    function showScale() {
        var ticks = scale.ticks(20);

        var div = d3.select(root + " .slider-selection").selectAll('div')
            .data(ticks);

        div.enter().append('div')
            .attr('class','slider-scale');

        div.exit().remove();

        div
            .style('background-color',function(d) { return scale(d) })
            .style('width', (Math.floor(100 / ticks.length * 10) / 10) + "%");

        $root.find(".scale b:first").html(slider.getAttribute('min'));
        $root.find(".scale b:last").html(slider.getAttribute('max'));
    }


    return {
        slider: slider,
        scale: scale,
        showScale: showScale
    }
};
