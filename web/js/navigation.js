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
    })
});
