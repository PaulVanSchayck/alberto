<?php
use yii\bootstrap\Modal;
?>

<div class="row svg-images">
    <div class="col-lg-6">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Late globular
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - EG" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - EG" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div class="panel-body row">
                <div class="col-lg-6 svg">
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?>
                </div>
                <div class="col-lg-6 svg">
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Heart stage
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="gene - LG" class="download-png">PNG</a></li>
                            <li><a href="#" title="gene - LG" class="download-svg">SVG</a></li>
                        </ul>
                    </span>
                </h3>
            </div>
            <div class="panel-body row">
                <div class="col-lg-6 svg">
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?>
                </div>
                <div class="col-lg-6 svg">
                    <?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-3">
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
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mode</h3>
            </div>
            <div class="panel-body mode">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" data-mode='abs' data-toggle="tooltip" title="View the absolute expression of genes.">Absolute</button>
                    <button type="button" class="btn btn-default" data-mode='fc' data-toggle="tooltip" title="View the fold changes of a gene compared to another gene.">Fold change</button>
                    <button type="button" class="btn btn-default" data-mode='rel' data-toggle="tooltip" title="View the fold changes of a gene compared to another gene.">Relative</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Tools</h3>
            </div>
            <div class="panel-body">

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
                            <li><a href="#"  target="_blank" data-template="http://www.arabidopsis.org/servlets/TairObject?type=locus&name=#AGI#">TAIR</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>