<?php
use yii\bootstrap\Modal;

$intact = Yii::$app->params['experiments']['intact'];
?>

<ul class="dropdown-menu actions" role="menu">
    <li class="dropdown-submenu">
        <a tabindex="-1" href="#">Absolute expression</a>
        <ul class="dropdown-menu">
            <li><a class='highest' href="#">Show highest expressed genes in this tissue</a></li>
            <li><a class='highest rsd' href="#">Show highest expressed genes with RSD < 50%</a></li>
        </ul>
    </li>
    <li class="divider"></li>
    <li class="dropdown-submenu">
        <a tabindex="-1" href="#">Spatial fold change</a>
        <ul class="dropdown-menu">
            <li><a class='enriched' href="#">Show enriched genes in this tissue</a></li>
            <li><a class='enriched significant' href="#">Show enriched genes with q-value < 0.05</a></li>
        </ul>
    </li>
</ul>

<div class="row svg-images">
    <div class="col-lg-12">
    <p>Click on the embryo for preset filtering actions, or use the table below for setting custom filters.</p>
    </div>
    <div class="col-lg-3">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Early globular stage
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - EG" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - EG" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div data-stage="eg" class="panel-body svg">
                <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?>
                <img src="/images/warning.png" class="warning-sign" alt="Warning Sign" data-toggle="tooltip" />
            </div>
        </div>

    </div>
    <div class="col-lg-3">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Late globular stage
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - LG" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - LG" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div data-stage="lg" class="panel-body svg">
                <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?>
                <img src="/images/warning.png" class="warning-sign" alt="Warning Sign" data-toggle="tooltip" />
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
            <div data-stage="hs" class="panel-body svg">
                <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?>
                <img src="/images/warning.png" class="warning-sign" alt="Warning Sign" data-toggle="tooltip" />
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
                <p class="unit mode-abs"><span class="label label-primary">Unit</span> Signal intensity (normalized)</p>
                <p class="unit mode-fc"><span class="label label-primary">Unit</span> Limma log2-based fold change</p>
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
                    <button type="button" class="btn btn-default" data-mode='abs' data-toggle="tooltip" title="View absolute gene expression">Absolute</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"  title="View spatio-temporal fold changes">
                            Fold changes <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-mode="fc_spt" target="_blank" data-toggle="tooltip"><b>Spatial</b> - Compared to the whole embryo</a></li>
                            <li><a href="#" data-mode="fc_tmp" target="_blank"><b>Temporal</b> - Compared to precursors in previous stages</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-default" data-mode='rel' data-toggle="tooltip" title="View the fold change of a gene relative to another gene">Relative</button>
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
                    Cell type-specific nuclei were isolated from early globular stage, late globular stage and
                    heart stage Arabidopsis embryos...
                </p>
                <?php Modal::begin([
                    'id' => 'experimentModal',
                    'header' => '<h4 class="modal-title">Experimental setup</h4>',
                    'toggleButton' => ['tag' => 'button', 'label' => 'Read more...', 'class' => 'btn btn-default'],
                    'size' => Modal::SIZE_LARGE
                ]);?>
                <?= \Michelf\MarkdownExtra::defaultTransform(file_get_contents(Yii::getAlias('@app') . '/experimentalsetup/intact.md')); ?>
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
                <div class="spinner spinner-table"><img src="/images/spinner.gif" alt="Loading" />Loading...</div>
                <button class="btn btn-default clearfilters">Clear all filters &raquo;</button>
                <?= $this->render('/_blocks/export', ['experiment' => 'intact']); ?>
                <?php Modal::begin([
                    'id' => 'visibilityModal',
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

                    <div class="col-lg-3 columns">
                        <b>Absolute expression</b>
                        <table class="column-checkboxes">
                            <tr>
                                <th><div>Exp.</div></th>
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
                <p><b>Exp.:</b> Expression value (mean) </p>
                <p><b>%RSD:</b> Relative Standard Deviation</p>
                <p><b>SD:</b> Standard Deviation</p>
                <p><b>FC:</b> Fold Change (Limma log2-based)</p>
                <p><b>q-value:</b> The False Discovery Rate (FDR) analogue of the p-value. The q-value of an individual hypothesis test is the minimum FDR at which the test may be called significant.</p>
                <?php Modal::end(); ?>
            </div>
            <table class="display" id="intactTable">
                <thead>
                <tr class="topHeader">
                    <th colspan="3">Gene information</th>
                    <th colspan="9">Early globular stage</th>
                    <th colspan="6">Late globular stage</th>
                    <th colspan="3">Heart stage</th>
                    <th colspan="14">Fold changes</th>
                </tr>
                <tr class="headers">
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
                            echo "<th>{$column['label']} q</th>\n";
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