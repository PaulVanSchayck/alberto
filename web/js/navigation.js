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
        navInfo.setExperiment($(this).data('exp'));

        return false;
    });

    $(window).on('alberto.gene.changed', function() {
        $('.at-input input').val(navInfo.getGene());

        // Only when the experiment is loaded do we also execute showGene
        $(window).one('experiment.loaded', function(){
            showGene(navInfo.getGene());
        })
    });

    $(window).on('alberto.experiment.changed', function() {
        var exp = navInfo.getExperiment(),
            $content = $("#" + exp);

        if ( $content.is(':empty') ) {
            // ajax load of tab
            $content.load("/index.php?r=site/tab&exp=" + exp);
        }

        $('a[data-exp="' + navInfo.getExperiment() + '"]').tab('show');

    });

    // Load from hash the gene and experiment, this will also trigger the events responsible for handling this
    navInfo.setFromHash();

    // Handle gene input
    $('.at-input input').on('typeahead:selected', function(event, selection) {
        showGene(selection.agi);
        navInfo.setGene(selection.agi);
    });

    try {
        isFileSaverSupported = !!new Blob;
    } catch (e) {}
});

var navInfo = {
    exp: "",
    gene: "",

    getExperiment: function() {
        return this.exp;
    },
    setExperiment: function(exp) {
        this.exp = exp;
        $(window).trigger('alberto.experiment.changed');
        this.buildHash();
    },

    getGene: function() {
        return this.gene;
    },
    setGene: function(gene) {
        this.gene = gene;
        $(window).trigger('alberto.gene.changed');
        this.buildHash();
    },

    setFromHash: function() {
        var hash = window.location.hash.split('-');

        if ( hash[0].trim() != '' ) {
            this.setExperiment(hash[0].replace('#',''));
        } else {
            this.setExperiment("start");
        }

        if ( hash[1].trim() != '' ) {
            this.setGene(hash[1]);
        }

        return this;
    },

    buildHash: function() {
        window.location.hash = $.grep([this.exp,this.gene], Boolean).join('-')
    }

};

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
