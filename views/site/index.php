<?php
/* @var $this yii\web\View */
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'AlBERTO - AraBidopsis Embryonic and Root Transcriptome brOwser';
?>
<div class="site-index">

    <div id="compability" style="display:none" class="alert alert-danger" role="alert">
        Your browser does not support all the features that this website requires, it will not function properly! Please use a more modern browser.
    </div>

    <div id="download-compability" style="display:none" class="alert alert-danger" role="alert">
        The download feature is not completely supported in your browser. Please use a modern version of either Chrome or Firefox.
    </div>

    <div id="relative-input" style="display:none">
        <p>Enter an AGI or gene name to obtain normalized expression values relative to this gene.</p>
        <div class="input-group">
            <span class="input-group-addon danger">Gene</span>
            <?php
            echo Typeahead::widget([
                'name' => 'relative-gene',
                'id' => 'relative-gene',
                'useHandleBars' => false,
                'options' => ['placeholder' => 'AT1G01010 or WOX'],
                'pluginOptions' => ['highlight' => true, 'autoselect' => true],
                'dataset' => [
                    [
                        'remote' => [
                            'url' => Url::to(['gene/autocomplete']) . '/%QUERY',
                            'wildcard' => '%QUERY'
                        ],
                        'limit' => 10,
                        'templates' => [
                            'empty' => '<p>Unable to find a matching gene.</p>',
                            'suggestion' => new JsExpression("function(o){ return '<p>'+o.agi+' '+o.gene+'</p>'; }")
                        ],
                        'displayKey' => 'agi'
                    ]
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="row top">

        <div class="col-lg-6">
            <p>Enter an AGI or gene name, select an experiment and press show.</p>
            <div class="input-group at-input">
                <span class="input-group-addon danger">Gene</span>
                <?php
                echo Typeahead::widget([
                    'name' => 'gene',
                    'id' => 'gene',
                    'useHandleBars' => false,
                    'options' => ['placeholder' => 'AT1G01010 or WOX'],
                    'pluginOptions' => ['highlight' => true, 'autoselect' => true],
                    'dataset' => [
                        [
                            'remote' => [
                                'url' => Url::to(['gene/autocomplete']) . '/%QUERY',
                                'wildcard' => '%QUERY'
                            ],
                            'limit' => 10,
                            'templates' => [
                                'empty' => '<p>Unable to find a matching gene.</p>',
                                'suggestion' => new JsExpression("function(o){ return '<p>'+o.agi+' '+o.gene+'</p>'; }")
                            ],
                            'displayKey' => 'agi'
                        ]
                    ]
                ]);
                ?>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-primary show-gene">Show</button>
                    <button type="button" class="btn btn-default btn-warning unshow-gene"><span class="glyphicon glyphicon-remove"></span></button>
                </span>
            </div>
        </div>
        <div id="no-results" style="visibility:hidden" class="col-lg-5 alert alert-danger" role="alert">
            No results for this gene were found in this experiment.
        </div>
        <div class="col-lg-1">
            <a href="<?=Url::to(['/site/index'])?>"><img src="/images/logo/logo1.png" class="logo" alt="Logo"/></a>
        </div>
    </div>



    <ul class="nav nav-tabs" id="experiments" role="tablist">
        <li data-toggle="tab">
            <a href="#start" data-exp="start" data-toggle="tooltip" data-original-title="Start"><span class="glyphicon glyphicon-home"></span></a>
        </li>

        <li data-toggle="tab">
            <a href="#help" data-exp="help" data-toggle="tooltip" data-original-title="Quick Start Guide"><span class="glyphicon glyphicon-question-sign"></span></a>
        </li>

        <li data-toggle="tab">
            <a href="#atlas" data-exp="atlas" data-toggle="tooltip" data-original-title="Spatio-temporal transcriptomes of cell type-specific nuclei in the early embryo">Cell type-specific</a>
        </li>

        <li data-toggle="tab">
            <a href="#q0990" data-exp="q0990" data-toggle="tooltip" data-original-title="Inhibition of ARF activity in ground and vascular tissue in the early embryo">Q0990>>bdl</a>
        </li>

        <li data-toggle="tab">
            <a href="#rootgradient" data-exp="rootgradient" data-toggle="tooltip" data-original-title="RNAseq data of differentially sorted root cells based on GFP gradient markers">Root gradients</a>
        </li>

        <?php if ( Yii::$app->user->isGuest === false ): ?>

        <li data-toggle="tab">
            <a href="#atlas_test" data-exp="atlas_test" data-toggle="tooltip" data-original-title="Spatio-temporal transcriptomes of cell type-specific nuclei in the early embryo">Cell type-specific (test)</a>
        </li>

        <li data-toggle="tab">
            <a href="#eightcell" data-exp="eightcell" data-toggle="tooltip" data-original-title="Inhibition of MONOPTEROS and other auxin response factors in the whole octant embryo">RPS5A>>bdl</a>
        </li>


        <li data-toggle="tab">
            <a href="#m0171" data-exp="m0171" data-toggle="tooltip" data-original-title="Inhibition of auxin response factors in the suspensor in the globular embryo">M0171>>bdl</a>
        </li>



        <?php endif; ?>
        <li class="pull-right spinner"><img src="/images/spinner.gif" alt="Loading" />Loading...</li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="start"></div>
        <div class="tab-pane active" id="help"></div>
        <div class="tab-pane active" id="atlas"></div>
        <div class="tab-pane active" id="atlas_test"></div>
        <div class="tab-pane active" id="eightcell"></div>
        <div class="tab-pane active" id="q0990"></div>
        <div class="tab-pane active" id="m0171"></div>
        <div class="tab-pane active" id="rootgradient"></div>
    </div>
</div>
