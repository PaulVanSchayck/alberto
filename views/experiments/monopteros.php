<?php
use yii\bootstrap\Modal;

/* @var $config [] */
/* @var $experimentName String */
?>

<?php $this->beginBlock('download'); ?>
<span class="btn-group">
    <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
    <ul class="dropdown-menu">
        <li><a href="#" title="gene - LG" class="download-png">PNG</a></li>
        <li><a href="#" title="gene - LG" class="download-svg">SVG</a></li>
    </ul>
</span>
<?php $this->endBlock(); ?>

<div class="row svg-images">
    <div class="col-lg-12">
        <p>Click on the embryo for preset filtering actions, or use the table below for setting your own filters.</p>
    </div>
    <div class="col-lg-4">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Late globular stage
                </h3>
            </div>
            <div class="panel-body row">
                <div class="col-lg-6 svg wt">
                    <span class="svg-label">Wild Type</span>
                    <?= $this->blocks['download'] ?>
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?>
                </div>
                <div class="col-lg-6 svg mp">
                    <span class="svg-label">Q0990>>bdl</span>
                    <?= $this->blocks['download'] ?>
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-5">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Heart stage
                </h3>
            </div>
            <div class="panel-body row">
                <div class="col-lg-6 svg wt">
                    <span class="svg-label">Wild Type</span>
                    <?= $this->blocks['download'] ?>
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?>
                </div>
                <div class="col-lg-6 svg mp">
                    <span class="svg-label">Q0990>>bdl</span>
                    <?= $this->blocks['download'] ?>
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-3">
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
                    <label class='checkbox-inline' data-toggle="tooltip" title="The default scale setting should be sufficient for most applications."><input type='checkbox' class="scale-input" >Enable changing scale</label>
                </div>
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
                    <button type="button" class="btn btn-default" data-mode='fc' data-toggle="tooltip" title="View fold changes of genes.">Fold change</button>
                </div>
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
                    MONOPTEROS (MP) is inhibited in the inner embryo proper cells of early Q0990>>bdl embryos...
                </p>
                <?php Modal::begin([
                    'id' => $experimentName . '-experiment',
                    'header' => '<h4 class="modal-title">Experimental setup</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'Read more...', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_LARGE
                ]);
                echo \Michelf\MarkdownExtra::defaultTransform(file_get_contents(Yii::getAlias('@app') . '/experimentalsetup/M0171.md'));
                ?>
                <?php Modal::end(); ?>
            </div>
        </div>
    </div>
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
                    <button class="btn btn-default clearfilters">Clear all filters &raquo;</button>
                    <?= $this->render('/_blocks/export', ['experiment' => 'Q0990']); ?>
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
                    <p><b>FC:</b> Fold change</p>
                    <p><b>q-value:</b> The False Discovery Rate (FDR) analogue of the p-value. The q-value of an individual hypothesis test is the minimum FDR at which the test may be called significant.</p>
                    <?php Modal::end(); ?>
                </div>
                <table class="display" id="<?=$experimentName?>-table">
                    <thead>
                    <tr class="headers">
                        <th>AGI</th>
                        <th>Gene</th>
                        <th>Annotation</th>
                        <?php
                        foreach( $config['columns'] as $column ) {
                            echo "<th>{$column['label']}</th>\n";
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
    var mpColumns = $.parseJSON('<?= json_encode($config['columns']); ?>');
    var mpRules = $.parseJSON('<?= json_encode($config['rules']); ?>');
    var mpImages = $.parseJSON('<?= json_encode($config['images']); ?>');
    navInfo.registerExperiment(mpExperiment("<?=$experimentName?>"));
</script>
