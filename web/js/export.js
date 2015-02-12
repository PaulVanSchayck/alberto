

window.alberto.exportModal = function($root, table, experiment) {

    var nGenes = $root.find(".exportModal .ngenes").slider().data('slider');

    $root.find(".exportModal .ngenes").next('.badge').click( function() {
       nGenes.setValue(2000);
    });

    $root.find(".exportModal .export").click(function () {
        var d = table.getLastRequest();

        for (var i = 0; i < d.columns.length; i++) {

            if ( $root.find(".visible").is(":checked") ) {
                d.columns[i].visible = true;
            } else {
                d.columns[i].visible = table.dt.column(d.columns[i].name + ":name").visible();
            }

        }

        d.start = 0;
        d.length = nGenes.getValue();
        d.includeAnnotations = $root.find(".exportModal .annotations").is(":checked") ? 1 : 0;

        // split params into form inputs
        var inputs = '';
        var data = decodeURIComponent(jQuery.param(d));

        $.each(data.split('&'), function () {
            var pair = this.split('=');
            inputs += '<input type="hidden" name="' + pair[0] + '" value="' + pair[1] + '" />';
        });

        // Yii2 CSRF protection
        inputs += '<input name="' + yii.getCsrfParam() + '" value="' + yii.getCsrfToken() + '" type="hidden">';

        // send request
        $('<form action="/gene/export/'+experiment+'" method="post">' + inputs + '</form>')
            .appendTo('body').submit().remove();
    });
};

