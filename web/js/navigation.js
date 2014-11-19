/***********
 * This file handles navigation through the tabs
 */

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

    $('#experiments a').click(function () {
        navInfo.setExperiment($(this).data('exp'));

        return false;
    });

    $(window).on('alberto.gene.changed', function(e, silent) {
        $("#no-results").hide();

        if ( navInfo.getGene() == false ) {
            unShowGene();
            $('.at-input input').val("");
            return;
        }

        $('.at-input input').val(navInfo.getGene());

        // Only show a gene, if the table is available, and this is not requested as a silent gene change
        if ( table && !silent) {
            showGene(navInfo.getGene());

        } else if ( !table && !silent ) {

            // Experiment has not loaded yet, wait for it, then show the gene
            $(window).one('experiment.loaded', function () {
                showGene(navInfo.getGene());
            });
        }
    });

    $(window).on('experiment.loaded', function () {

        // If there is no gene selected, load the default table
        if (! navInfo.getGene()) {
            table.ajax.reload();
        }
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

    // Handle gene input from typeahead dropdown
    $('.at-input input').on('typeahead:selected', function(event, selection) {
        navInfo.setGene(selection.agi);
    });

    $('.at-input .show-gene').on('click', function(e) {
        e.preventDefault();
        if ( $('.at-input input').val() != "" ) {
            navInfo.setGene($('.at-input input').val())
        }
    });

    $('.at-input .unshow-gene').on('click', function(e) {
        e.preventDefault();
        navInfo.setGene(false)
    })

});

var navInfo = {
    exp: "",
    gene: false,
    mode: "",

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
    setGene: function(gene, silent) {
        this.gene = gene;

        $(window).trigger('alberto.gene.changed', silent);

        this.buildHash();
    },

    getMode: function() {
        return this.mode;
    },

    setMode: function(mode) {
        this.mode = mode;

        $(window).trigger('alberto.mode.changed');
    },

    setFromHash: function() {
        var hash = window.location.hash.split('-');

        if ( hash[1] && hash[1].trim() != '' ) {
            this.setExperiment(hash[1].replace('#',''));
        } else {
            this.setExperiment("start");
        }

        if ( hash[2] && hash[2].trim() != '' ) {
            this.setGene(hash[2]);
        }

        return this;
    },

    buildHash: function() {
        // We're prefixing the hash so that we do actually have real elements to scroll to
        window.location.hash = "nav-" + $.grep([this.exp,this.gene], Boolean).join('-')
    }

};

function saveAsSVG(svg, title) {
    if (! Modernizr.blobconstructor ) {
        $("#download-compability").show();
        return false;
    } else if( ! Modernizr.adownload ) {
        $("#download-compability").show();
    }

    var svgStr =  (new XMLSerializer()).serializeToString(svg);
    var blob = new Blob([svgStr], {type: "image/svg+xml"});
    saveAs(blob, title + ".svg");
}

function saveAsPNG(svg, title) {
    if (! Modernizr.blobconstructor ) {
        $("#download-compability").fadeIn();
        return false;
    } else if( ! Modernizr.adownload ) {
        $("#download-compability").fadeIn();
    }

    var svgStr =  (new XMLSerializer()).serializeToString(svg),
        can    = document.createElement('canvas'),
        ctx    = can.getContext('2d'),
        loader = new Image();

    can.width = loader.height = 300;
    can.height = loader.height = 300;

    loader.onload = function() {
        ctx.drawImage( loader, 0, 0 );

        try {
            can.toBlob(function(blob) {
                saveAs(blob, title + ".png");
            });
        } catch ( e ) {
            // Notably IE9 - IE11 do not support this
            $("#download-compability").fadeIn();
        }
    };

    loader.src = 'data:image/svg+xml,' + encodeURIComponent( svgStr );
}
