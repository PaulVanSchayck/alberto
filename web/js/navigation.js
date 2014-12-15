/***********
 * This file handles navigation through the tabs
 */

window.alberto = {};

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
            $('.at-input input')
                .val("")
                .removeClass('loaded');
            return false;
        }

        $('.at-input input')
            .val(navInfo.getGene())
            .addClass('loaded');

        // Only show a gene, if the table is available, and this is not requested as a silent gene change
        if ( navInfo.getExperimentObj() && !silent) {
            navInfo.getExperimentObj().filterGene(navInfo.getGene());

        } else if ( navInfo.getExperimentObj() && silent ) {
            navInfo.getExperimentObj().showGene();
        }
    });

    $(window).on('experiment.loaded', function () {

        // If there is no gene selected, load the default table
        if (! navInfo.getGene()) {
            navInfo.getExperimentObj().reloadTable();
        } else {
            navInfo.getExperimentObj().filterGene(navInfo.getGene());
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

        // Only filter a gene when the experiment is changed when the gene set for the experiment differs from the currently set gene
        if ( navInfo.getExperimentObj() && navInfo.getExperimentGene() != navInfo.getGene() ) {
            navInfo.getExperimentObj().filterGene(navInfo.getGene());
        }

    });

    // Load from hash the gene and experiment, this will also trigger the events responsible for handling this
    navInfo.setFromHash();

    // Handle gene input from typeahead dropdown
    $('.at-input input').on('typeahead:selected', function(event, selection) {
        navInfo.setGene(selection.agi);
    });

    $('.at-input input').on('keydown', function() {
        $(this).removeClass('loaded');
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
    });

    $(".tab-content").on('click','.download-svg', function(e) {
        e.preventDefault();
        saveAsSVG($(this).parents('.panel').find('svg')[0],$(this).attr('title').replace('gene',navInfo.getGene()));
    });

    $(".tab-content").on('click','.download-png', function(e) {
        e.preventDefault();
        saveAsPNG($(this).parents('.panel').find('svg')[0],$(this).attr('title').replace('gene',navInfo.getGene()));
    });
});

var navInfo = {
    exp: "",
    gene: false,
    mode: "",
    experiments: {},

    getExperiment: function() {
        return this.exp;
    },
    setExperiment: function(exp) {
        this.exp = exp;

        $(window).trigger('alberto.experiment.changed');
        this.buildHash();
    },
    registerExperiment: function(expObj) {
        this.experiments[this.getExperiment()] = { obj: expObj, gene: this.getGene() };

        expObj.load();
    },

    getGene: function() {
        return this.gene;
    },
    getExperimentGene: function() {
        if ( this.experiments[this.getExperiment()] ) {
            return this.experiments[this.getExperiment()].gene;
        } else {
            return false;
        }
    },
    getExperimentObj: function() {
        if ( this.experiments[this.getExperiment()] ) {
            return this.experiments[this.getExperiment()].obj;
        } else {
            return false;
        }
    },
    setGene: function(gene, silent) {
        this.gene = gene;

        if ( this.experiments[this.getExperiment()] ) {
            this.experiments[this.getExperiment()].gene = gene;
        }

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

