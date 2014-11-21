<?php
use yii\bootstrap\Modal;

$intact = Yii::$app->params['experiments']['intact'];
?>

<ul class="dropdown-menu actions" role="menu">
    <li><a href="#">Show highest expressed genes in this tissue</a></li>
</ul>

<div class="row svg-images">
    <div class="col-lg-3">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Early globular
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - EG" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - EG" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div class="panel-body svg">
                <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?>
            </div>
        </div>

    </div>
    <div class="col-lg-3">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Late globular
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - LG" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - LG" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div class="panel-body svg">
                <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?>
            </div>
        </div>

    </div>
    <div class="col-lg-3">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Heart stage
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - HS" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - HS" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div class="panel-body svg">
                <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?>
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
            <div class="panel-body" id="gene-information">
                <div class='non-selected' data-toggle="tooltip" title="Select a gene using the search above, or the table below.">None selected yet...</div>
                <div class="selected">
                    <h4><span class="label label-success">AGI</span> <span class="agi"></span></h4>
                    <p><span class="label label-primary">Gene</span> <span class="gene"></span></p>

                    <pre class="annotation"></pre>
                    <div class="btn-group" id="tools">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            External tools <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Seed&modeInput=Absolute&primaryGene=#AGI#">eFP Seed</a></li>
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Tissue_Specific&modeInput=Absolute&primaryGene=#AGI#">eFP Tissue Specific</a></li>
                            <li><a href="#"  target="_blank" data-template="http://www.arabidopsis.org/servlets/TairObject?type=locus&name=#AGI#">TAIR</a></li>
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
            <div class="panel-body" id="scale">
                <b class="badge">0</b>
                <input type="text" id="scale-slider" class="form-control" name="scale" data-slider-min="0" data-slider-max="2000" data-slider-step="1" data-slider-value="[30,1000]" data-plugin-name="slider" title="slider">
                <b class="badge">2000</b>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mode</h3>
            </div>
            <div class="panel-body" id="mode">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" data-mode='abs' data-toggle="tooltip" title="View the absolute expression of genes.">Absolute</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Fold changes <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-mode="fc_spt" target="_blank" data-template="#">Spatial</a></li>
                            <li><a href="#" data-mode="fc_tmp" target="_blank" data-template="#">Temporal</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-default" data-mode='rel' data-toggle="tooltip" title="View the fold changes of a gene compared to another gene.">Relative</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Tools</h3>
            </div>
            <div class="panel-body">
                <p><button class="btn btn-default" id="clearfilters">Clear all filters &raquo;</button></p>
                <?php Modal::begin([
                    'id' => 'exportModal',
                    'header' => '<h4 class="modal-title">Export</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'CSV Export &raquo;', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_DEFAULT
                ]);?>
                <p>
                    <label>Export all columns:
                        <input type="checkbox" class="visible">
                    </label>
                </p>

                <p>Per default only columns visible in the current table are exported.</p>

                <p>
                    <label>Maximum number of genes:
                        <b class="badge">0</b>
                         <input type="text" class="form-control ngenes" data-slider-min="0" data-slider-max="2000" data-slider-step="1" data-slider-value="1000" data-plugin-name="slider" title="Maximum number of genes">
                        <b class="badge">2000</b>
                    </label>
                </p>

                <p>The export is limited to 2000 genes. If you would like to view more genes in an export, you're
                    recommended to download the full dataset and perform the filtering yourself.</p>

                <p>
                    <label>Include annotations:
                        <input type="checkbox" class="annotations">
                    </label>
                </p>

                <p>The annotations increase the download size of the export significantly</p>

                <p><button class="btn btn-primary" id="export">Export &raquo;</button></p>
                <?php Modal::end(); ?>
                <p></p>
                <?php Modal::begin([
                    'id' => 'visibilityModal',
                    'header' => '<h4 class="modal-title">Set column visibility</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'Show / hide columns &raquo;', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_LARGE
                ]);?>
                <div class="row">
                    <div class="col-lg-2 columns">
                        <b>General columns</b>
                        <div class="sd">&nbsp;</div>
                        <div class="checkbox">
                            <label class="checkbox-inline"><input type="checkbox" value="" name="gene.gene"> Gene</label>
                        </div>
                        <div class="checkbox">
                            <label class="checkbox-inline"><input type="checkbox" value="" name="gene.annotation">Annotation</label>
                        </div>
                    </div>

                    <div class="col-lg-3 columns">
                        <b>Absolute expression</b>
                        <div class="sd">SD</div>
                        <?php
                        foreach( $intact['columns'] as $column ) {
                            if ( $column['type'] != 'abs' ) {
                                continue;
                            }
                            echo "<div class='checkbox checkbox-double column'>\n";
                                echo "<label class='checkbox-inline'><input type='checkbox' name='{$column['field']}_sd'><input type='checkbox' name='{$column['field']}'> {$column['label']}</label>";
                            echo "</div>";
                        }
                        ?>
                        <div class="checkbox checkbox-double all">
                            <label class='checkbox-inline'><input type="checkbox" name="all-sd" /><input type="checkbox" name="all" /> <b>All</b></label>
                        </div>
                    </div>

                    <div class="col-lg-3 columns">
                        <b>Spatial fold changes</b>
                        <div class="sd">Q</div>
                        <?php
                        foreach( $intact['columns'] as $column ) {
                            if ( $column['type'] != 'fc_spt' ) {
                                continue;
                            }
                            echo "<div class='checkbox checkbox-double column'>\n";
                            echo "<label class='checkbox-inline'><input type='checkbox' name='{$column['field']}_q'><input type='checkbox' name='{$column['field']}'> {$column['label']}</label>";
                            echo "</div>";
                        }
                        ?>
                        <div class="checkbox checkbox-double all">
                            <label class='checkbox-inline'><input type="checkbox" name="all" /><input type="checkbox" name="all-sd" /> <b>All</b></label>
                        </div>
                    </div>

                    <div class="col-lg-4 columns">
                        <b>Temporal fold changes</b>
                        <div class="sd">Q</div>
                        <?php
                        foreach( $intact['columns'] as $column ) {
                            if ( $column['type'] != 'fc_tmp' ) {
                                continue;
                            }
                            echo "<div class='checkbox checkbox-double column'>\n";
                            echo "<label class='checkbox-inline'><input type='checkbox' name='{$column['field']}_q'><input type='checkbox' name='{$column['field']}'> {$column['label']}</label>";
                            echo "</div>";
                        }
                        ?>
                        <div class="checkbox checkbox-double all">
                            <label class='checkbox-inline'><input type="checkbox" name="all" /><input type="checkbox" name="all-sd" /> <b>All</b></label>
                        </div>
                    </div>
                </div>



                <?php Modal::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table id="example" class="display">
                    <thead>
                    <tr>
                        <th>AGI</th>
                        <th>Gene</th>
                        <th>Annotation</th>
                <?php
                foreach( $intact['columns'] as $column ) {
                    echo "<th>{$column['label']}</th>\n";
                    if ( $column['type'] == 'abs' ) {
                        echo "<th>{$column['label']} SD</th>\n";
                    } else if ( $column['type'] == 'fc_tmp' ) {
                        echo "<th>{$column['label']} Q</th>\n";
                    } else if ( $column['type'] == 'fc_spt' ) {
                        echo "<th>{$column['label']} Q</th>\n";
                    }
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
</div>

<script type="text/javascript">
    var intactColumns = $.parseJSON('<?= json_encode($intact['columns']); ?>');
    var intactRules = $.parseJSON('<?= json_encode($intact['rules']); ?>');
    loadExperiment();
</script>