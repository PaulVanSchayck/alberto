<?php
use yii\bootstrap\Modal;

$intact = Yii::$app->params['experiments']['intact'];
?>

<ul class="dropdown-menu actions" role="menu">
    <li class="dropdown-submenu">
        <a tabindex="-1" href="#">Absolute expression</a>
        <ul class="dropdown-menu">
            <li><a class='highest' href="#">Show genes present in this tissue</a></li>
            <li><a class='not-expressed' href="#">Show genes not present in this tissue</a></li>
        </ul>
    </li>
    <li class="divider"></li>
    <li class="dropdown-submenu">
        <a tabindex="-1" href="#">Fold changes</a>
        <ul class="dropdown-menu">
            <li><a class='enriched' href="#">Show genes enriched in this tissue</a></li>
            <li><a class='enriched significant' href="#">Show statistically significant genes enriched in this tissue</a></li>
        </ul>
    </li>
</ul>

<div class="row svg-images">
    <div class="col-lg-12">
    <p>Click on the embryo for preset filtering actions, or use the table below for setting your own filters.</p>
    </div>
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
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Seed&modeInput=Absolute&primaryGene=#AGI#">eFP Seed</a></li>
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Tissue_Specific&modeInput=Absolute&primaryGene=#AGI#">eFP Tissue Specific</a></li>
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Root&modeInput=Absolute&primaryGene=#AGI#">eFP Root</a></li>
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
                    <label class='checkbox-inline' data-toggle="tooltip" title="The default scale setting should be sufficient for most applications."><input type='checkbox' class="scale-input" >Disable auto scaling</label>
                </div>
                <p class="mode-abs">
                    Values below 32 are considered not expressed.
                </p>
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
                    <button type="button" class="btn btn-default" data-mode='abs' data-toggle="tooltip" title="View the absolute expression of genes.">Absolute</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Fold changes <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-mode="fc_spt" target="_blank" data-toggle="tooltip"><b>Spatial</b> - A tissue compared to the whole embryo.</a></li>
                            <li><a href="#" data-mode="fc_tmp" target="_blank"><b>Temporal</b> - A tissue compared to it predecessor in the previous stage</a></li>
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
                <h3 class="panel-title">Experimental setup</h3>
            </div>
            <div class="panel-body">
                <p>
                    Nuclear transcriptomic profiles were collected from individual cell types isolated
                    with help of cell type specific promoters.
                </p>
                <?php Modal::begin([
                    'id' => 'experimentModal',
                    'header' => '<h4 class="modal-title">Experimental setup</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'Read more...', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_DEFAULT
                ]);?>
                We aborted genetically modified embryos!
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
                <?php Modal::begin([
                    'id' => 'exportModal',
                    'header' => '<h4 class="modal-title">Export to CSV file</h4>',
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
                <?php Modal::begin([
                    'id' => 'visibilityModal',
                    'header' => '<h4 class="modal-title">Show / hide columns</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'Show / hide columns &raquo;', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_LARGE
                ]);?>
                <div class="row">
                    <div class="col-lg-2 columns">
                        <b>General columns</b>
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

                    <div class="col-lg-3 columns">
                        <b>Absolute expression</b>
                        <table class="column-checkboxes">
                            <tr>
                                <th><div>Exp</div></th>
                                <th><div>%RSD</div></th>
                                <th><div>SD</div></th>
                            </tr>

                            <?php
                            foreach( $intact['columns'] as $column ) {
                                if ( $column['type'] != 'abs' ) {
                                    continue;
                                }
                                echo "<tr class='field'>";
                                echo "<td><input type='checkbox' id='{$column['field']}'></td>\n";
                                echo "<td><input type='checkbox' id='{$column['field']}_rsd'></td>\n";
                                echo "<td><input type='checkbox' id='{$column['field']}_sd'></td>\n";
                                echo "<td><label for='{$column['field']}' class='checkbox-inline'>{$column['label']}</label></td>";
                                echo "</tr>";
                            }
                            ?>
                            <tr class="all">
                                <td><input type="checkbox" name="all" /></td>
                                <td><input type="checkbox" name="all-rsd" /></td>
                                <td><input type="checkbox" name="all-sd" /></td>
                                <td><b>All</b></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-lg-3 columns">
                        <b>Spatial fold changes</b>
                        <table class="column-checkboxes">
                            <tr>
                                <th><div>FC</div></th>
                                <th><div>q-value</div></th>
                            </tr>
                            <?php
                            foreach( $intact['columns'] as $column ) {
                                if ( $column['type'] != 'fc_spt' ) {
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

                    <div class="col-lg-4 columns">
                        <b>Temporal fold changes</b>
                        <table class="column-checkboxes">
                            <tr>
                                <th><div>FC</div></th>
                                <th><div>q-value</div></th>
                            </tr>
                            <?php
                            foreach( $intact['columns'] as $column ) {
                                if ( $column['type'] != 'fc_tmp' ) {
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
                <p><b>Exp:</b> Expression</p>
                <p><b>%RSD:</b> Relative Standard deviation</p>
                <p><b>SD:</b> Standard deviation</p>
                <p><b>FC:</b> Fold change</p>
                <p><b>q-value:</b> The False Discovery Rate (FDR) analogue of the p-value. The q-value of an individual hypothesis test is the minimum FDR at which the test may be called significant.</p>
                <?php Modal::end(); ?>
            </div>
            <table class="display" id="intactTable">
                <thead>
                <tr>
                    <th>AGI</th>
                    <th>Gene</th>
                    <th>Annotation</th>
                    <?php
                    foreach( $intact['columns'] as $column ) {
                        echo "<th>{$column['label']}</th>\n";
                        if ( $column['type'] == 'abs' ) {
                            echo "<th>{$column['label']} %RSD</th>\n";
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




<script type="text/javascript">
    var intactColumns = $.parseJSON('<?= json_encode($intact['columns']); ?>');
    var intactRules = $.parseJSON('<?= json_encode($intact['rules']); ?>');
    navInfo.registerExperiment(intactExperiment("#intact"));
</script>