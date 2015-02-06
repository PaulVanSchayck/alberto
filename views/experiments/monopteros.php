<?php
use yii\bootstrap\Modal;

/* @var $config [] */
/* @var $experimentName String */
?>

<ul class="dropdown-menu actions" role="menu">
    <li class="dropdown-submenu">
        <a tabindex="-1" href="#">Fold change</a>
        <ul class="dropdown-menu">
            <li><a class='up' href="#">Show genes up-regulated in the mutant</a></li>
            <li><a class='down' href="#">Show genes down-regulated in the mutant</a></li>
        </ul>
    </li>
</ul>

<?php $this->beginBlock('download'); ?>
<span class="btn-group pull-right">
    <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
    <ul class="dropdown-menu">
        <li><a href="#" title="gene - Q0990" class="download-png">PNG</a></li>
        <li><a href="#" title="gene - Q0990" class="download-svg">SVG</a></li>
    </ul>
</span>
<?php $this->endBlock(); ?>

<div class="row svg-images">
    <div class="col-lg-12">
        <p>Click on the embryo for preset filtering actions, or use the table below for setting your own filters.</p>
    </div>

    <?php foreach( $config['images'] as $stage => $image ): ?>
        <div class="col-lg-3">

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?= $image['label'] ?>
                        <?= $this->blocks['download'] ?>
                    </h3>

                </div>
                <div class="panel-body row svg <?=$stage?>" data-stage="<?=$stage?>">
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/' . $image['file']); ?>
                </div>
            </div>

        </div>
    <?php endforeach ?>

    <div class="col-lg-3 col-lg-offset-<?= ( 12 - 3 - count($config['images']) * 3 )?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Gene information
                </h3>
            </div>
            <div class="panel-body gene-information">
                <div class='non-selected' data-toggle="tooltip" title="Select a gene using the search above, or the table below.">None selected yet...</div>
                <div class="selected">
                    <h4><span class="label label-success">AGI</span> <span class="agi"></span></h4>
                    <p><span class="label label-primary">Gene</span> <span class="gene"></span></p>

                    <pre class="annotation"></pre>
                    <div class="btn-group tools">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            External tools <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" target="_blank" data-template="http://www.arabidopsis.org/servlets/TairObject?type=locus&name=#AGI#">TAIR</a></li>
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Seed&modeInput=Absolute&primaryGene=#AGI#">eFP Seed</a></li>
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Tissue_Specific&modeInput=Absolute&primaryGene=#AGI#">eFP Tissue Specific</a></li>
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Root&modeInput=Absolute&primaryGene=#AGI#">eFP Root</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Scale</h3>
            </div>
            <div class="panel-body scale">
                <b class="badge">0</b>
                <input type="text" class="scale-slider form-control" name="scale" data-slider-min="0" data-slider-max="150" data-slider-step="1" data-slider-value="[32,100]" data-plugin-name="slider" title="slider">
                <b class="badge">150</b>
                <div class='checkbox'>
                    <label class='checkbox-inline' data-toggle="tooltip" title="The default scale setting should be sufficient for most applications"><input type='checkbox' class="scale-input" >Disable auto scaling</label>
                </div>
                <p class="unit mode-fc"><span class="label label-primary">unit</span> Fold change (log2)</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mode</h3>
            </div>
            <div class="panel-body mode">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" data-mode='fc' data-toggle="tooltip" title="View fold changes of genes">Fold change</button>
                </div>
                <p class="mode-note">Fold changes are calculated with the wild-type embryo as the base.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Experimental setup</h3>
            </div>
            <div class="panel-body">
                <p>
                    <?= $config['experimentalSetup']['note'] ?>
                </p>
                <?php Modal::begin([
                    'id' => $experimentName . '-experiment',
                    'header' => '<h4 class="modal-title">Experimental setup</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'Read more...', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_LARGE
                ]);
                echo \Michelf\MarkdownExtra::defaultTransform(file_get_contents(Yii::getAlias('@app') . '/experimentalsetup/' . $config['experimentalSetup']['file']));
                ?>
                <?php Modal::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-danger" role="alert">
    <?= $config['note'] ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Transcriptomic profiles</h3>
            </div>
            <div class="panel-body">
                <p class="table-text">Click on a row to view the profile of a gene. Use the fields to filter the table.</p>
                <div class="table-tools">
                    <div class="spinner spinner-table"><img src="/images/spinner.gif" alt="Loading" />Loading...</div>
                    <button class="btn btn-default clearfilters">Clear all filters &raquo;</button>
                    <?= $this->render('/_blocks/export', ['experiment' => $experimentName]); ?>
                    <?php Modal::begin([
                        'id' => $experimentName . '-visibilityModal',
                        'header' => '<h4 class="modal-title">Show / hide columns</h4>',
                        'toggleButton' => ['tag' => 'button', 'label' => 'Show / hide columns &raquo;', 'class' => 'btn btn-default'],
                        'size' => Modal::SIZE_LARGE
                    ]);?>
                    <div class="row visibilityModal">
                        <div class="col-lg-2 columns">
                            <b>Gene information</b>
                            <table class="column-checkboxes">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr class='field'>
                                    <td><input type="checkbox" id="gene.gene"></td>
                                    <td><label class="checkbox-inline" for="gene.gene">Gene</label></td>
                                </tr>
                                <tr class='field'>
                                    <td><input type="checkbox" id="gene.annotation"></td>
                                    <td><label class="checkbox-inline" for="gene.gene">Annotation</label>
                                    </td></tr>
                            </table>
                        </div>

                        <div class="col-lg-4 columns">
                            <b>Fold changes</b>
                            <table class="column-checkboxes">
                                <tr>
                                    <th><div>FC</div></th>
                                    <th><div>q-value</div></th>
                                </tr>
                                <?php
                                foreach( $config['columns'] as $column ) {
                                    if ( $column['type'] != 'fc' ) {
                                        continue;
                                    }
                                    echo "<tr class='field'>";
                                    echo "<td><input type='checkbox' id='{$column['field']}'></td>\n";
                                    echo "<td><input type='checkbox' id='{$column['field']}_q'></td>\n";
                                    echo "<td><label for='{$column['field']}' class='checkbox-inline'>{$column['label']}</label></td>";
                                    echo "</tr>";
                                }
                                ?>
                                <tr class="all">
                                    <td><input type="checkbox" name="all" /></td>
                                    <td><input type="checkbox" name="all-q" /></td>
                                    <td><b>All</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <p><b>FC:</b> Fold Change (log2)</p>
                    <p><b>q-value:</b> The False Discovery Rate (FDR) analogue of the p-value. The q-value of an individual hypothesis test is the minimum FDR at which the test may be called significant.</p>
                    <?php Modal::end(); ?>
                </div>
                <table class="display" id="<?=$experimentName?>-table">
                    <thead>
                    <tr class="headers">
                        <th>AGI</th>
                        <th>Gene</th>
                        <th>Annotation</th>
                        <th>Splice variant</th>
                        <?php
                        foreach( $config['columns'] as $column ) {
                            echo "<th>{$column['label']}</th>\n";
                            echo "<th>{$column['label']} q</th>\n";
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

<script type="text/javascript">
    var columns = $.parseJSON('<?= json_encode($config['columns']); ?>');
    var rules = $.parseJSON('<?= json_encode($config['rules']); ?>');
    var images = $.parseJSON('<?= json_encode($config['images']); ?>');
    navInfo.registerExperiment(mpExperiment("<?=$experimentName?>", rules, images, columns));
</script>
