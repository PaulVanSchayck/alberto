

function parseRuleField(field, data, postfix) {

    if (postfix == undefined) {
        postfix = '';
    }

    if (field === false) {
        return false;
    }

    if (field == 'no-data') {
        return 'no-data';
    }

    if (data[field] !== undefined) {
        return data[field + postfix];
    }
}


function showGeneInformation($root, data) {
    $root.find('.gene-information .non-selected').hide();
    var $gene = $root.find('.gene-information .selected').show();

    $gene.find('.agi').html(data.gene_agi);
    $gene.find('.annotation').html(data.gene.annotation);
    $gene.find('.gene').html(data.gene.gene);

    $gene.find('.tools li a').each(function(i,e){
        $(e).attr('href', function() {
            return $(this).data('template').replace('#AGI#', data.gene_agi);
        });
    });
}

function hideGeneInformation($root) {
    $root.find('.gene-information .non-selected').show();
    $root.find('.gene-information .selected').hide();
}


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
        loader = new Image(),
        viewBox = (svg.getAttribute('viewBox') || '').match(/-?[\d\.]+/g);

    loader.width = can.width = viewBox[2];
    loader.height = can.height = viewBox[3];

    loader.onload = function() {
        ctx.drawImage( loader, 0, 0, loader.width, loader.height);

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

jQuery.fn.visible = function() {
    return this.css('visibility', 'visible');
};

jQuery.fn.invisible = function() {
    return this.css('visibility', 'hidden');
};

function noGeneFound() {
    $("#no-results").visible();
}

function geneFound() {
    $("#no-results").invisible();
}