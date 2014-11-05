<div class="row svg-images">
    <div class="col-lg-3">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Early globular
                    <span class="btn-group pull-right">
                        <a href="#" class="dropdown-toggle download-drop" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" title="EG - gene" class="download-png">PNG</a></li>
                            <li><a href="#" title="EG - gene" class="download-svg">SVG</a></li>
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
                            <li><a href="#" title="LG - gene" class="download-png">PNG</a></li>
                            <li><a href="#" title="LG - gene" class="download-svg">SVG</a></li>
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
                            <li><a href="#" title="HS - gene" class="download-png">PNG</a></li>
                            <li><a href="#" title="HS - gene" class="download-svg">SVG</a></li>
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
                            <li><a href="#" target="_blank" data-template="http://bar.utoronto.ca/efp/cgi-bin/efpWeb.cgi?dataSource=Developmental_Map&modeInput=Absolute&primaryGene=#AGI#">eFP</a></li>
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
                <input type="text" id="scale-slider" class="form-control" name="scale" data-slider-min="0" data-slider-max="2000" data-slider-step="1" data-slider-value="[30,1000]" data-plugin-name="slider">
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
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" title="View the absolute expression of genes.">Absolute</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" title="View the fold changes of the same gene between tissues.">Fold changes</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" title="View the fold changes of a gene compared to another gene.">Relative</button>
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
                <p><button class="btn btn-default" id="change">Test coloring &raquo;</button></p>
                <p><button class="btn btn-default" id="original">Original coloring &raquo;</button></p>
                <p><button class="btn btn-default" id="permalink">Permalink &raquo;</button></p>
            </div>
        </div>
    </div>
</div>

<table id="example" class="display">
    <thead>
    <tr>
        <th>agi</th>
        <th>Gene</th>
        <th>Suspensor EG</th>
        <th>Vascular EG</th>
        <th>Whole embryo EG</th>
        <th>Vascular LG</th>
        <th>Whole embryo LG</th>
        <th>Hypophysis HS</th>
        <th>FC Vascular LG</th>

    </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script type="text/javascript">
    loadExperiment();
</script>