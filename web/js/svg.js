/**
 * Module for functions for controlling the SVG images
 */

window.alberto.svg = function svg($root, tissues) {

    function setupTooltip(ele, formatCallback) {
        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .direction('e')
            .offset([0, 20])
            .html(function (d) {
                if (d) {
                    return formatCallback(d)
                } else {
                    return "N/A";
                }
            });

        ele.call(tip);

        $.each(tissues, function (i, tissue) {
            ele.select('.' + tissue)
                .on('mouseover', function (d, i) {

                    tip.show(d, i);

                    var g = d3.select(this);
                    if (g.attr('in-transition') == undefined || g.attr('in-transition') == 'no') {
                        g.transition().style("opacity", 0.5);
                    }

                })
                .on('mouseout', function (d, i) {
                    tip.hide(d, i);

                    var g = d3.select(this);

                    if (g.attr('in-transition') == undefined || g.attr('in-transition') == 'no') {
                        g.transition().style("opacity", 1);
                    }

                })
                /* Make only the tissue accessible for pointer events and thus the tooltip */
                .attr('class', tissue + ' pointer-events')
        });
    }

    function assignData(ele, data) {

        $.each(tissues, function (i, tissue) {
            ele.select('.' + tissue)
                .data([data[i]])
        });
    }

    function retrieveFillColor(ele) {
        var color = [];

        $.each(tissues, function (i, tissue) {
            if (!ele.select('.' + tissue).empty()) {
                color[i] = ele.select('.' + tissue).attr('fill');
            }
        });

        return d3.scale.ordinal().range(color);
    }

    return {
        setupTooltip: setupTooltip,
        retrieveFillColor: retrieveFillColor,
        assignData: assignData
    }
};