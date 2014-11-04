/***********
 * This file handles navigation through the tabs
 */

var isFileSaverSupported = false;

$(document).ready(function(){

    /* Show or hide spinner */
    var $loading = $('#spinner').hide();

    $(document)
        .ajaxStart(function () {
            $loading.show();
        })
        .ajaxStop(function () {
            $loading.hide();
        });

    $("#experiments a").tooltip({'placement': 'bottom'});

    $('#experiments a').click(function (e) {
        e.preventDefault();

        var exp = $(this).attr("data-exp"),
            $content = $(this.hash),
            $tab = $(this);

        if ( $content.is(':empty') ) {
            // ajax load of tab
            $(this.hash).load("/index.php?r=site/tab&exp=" + exp, function() {
                loadExperiment();
            });
        }

        $tab.tab('show');

        return false;
    });

    // load first tab content
    $('#experiments li:first a').click();

    // Handle gene input
    $('#gene-show').submit( function() {
        showGene($("#gene").val());

        return false;
    });

    try {
        isFileSaverSupported = !!new Blob;
    } catch (e) {}
});

function saveAsSVG(svg, title) {
    if (! isFileSaverSupported ) {
        alert("This browser does not support this feature, please use a modern version of either Chrome or Firefox");
        return false;
    }

    var svgStr =  (new XMLSerializer()).serializeToString(svg);
    var blob = new Blob([svgStr], {type: "image/svg+xml;charset=utf-8"});
    saveAs(blob, title + ".svg");
}

function saveAsPNG(svg, title) {
    var svgStr =  (new XMLSerializer()).serializeToString(svg),
        can    = document.createElement('canvas'),
        ctx    = can.getContext('2d'),
        loader = new Image();

    can.width = loader.height = 300;
    can.height = loader.height = 300;

    loader.onload = function() {
        ctx.drawImage( loader, 0, 0 );

        try {
            if ( ! isFileSaverSupported ) {
                throw "Not supported";
            }

            can.toBlob(function(blob) {
                saveAs(blob, title + ".png");
            });
        } catch ( e ) {
            // Notably IE9 - IE11 do not support this
            alert("This browser does not support this feature, please use a modern version of either Chrome or Firefox");
        }
    };

    loader.src = 'data:image/svg+xml,' + encodeURIComponent( svgStr );
}