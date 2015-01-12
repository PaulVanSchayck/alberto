<?php
/* @var $this yii\web\View */
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'AlBERTO';
?>
<div class="site-index">

    <div id="compability" style="display:none" class="alert alert-danger" role="alert">
        Your browser does not support all the features that this website requires, it will not function properly! Please use a more modern browser.
    </div>

    <div id="download-compability" style="display:none" class="alert alert-danger" role="alert">
        The download feature is not completely supported in your browser. Please use a modern version of either Chrome or Firefox.
    </div>

    <p>Enter an AGI or gene name, select an experiment and press show.</p>

    <div class="row">
        <div class="col-lg-6">
            <div class="input-group at-input">
                <span class="input-group-addon danger">Gene</span>
                <?php
                echo Typeahead::widget([
                    'name' => 'gene',
                    'id' => 'gene',
                    'useHandleBars' => false,
                    'options' => ['placeholder' => 'AT1G01010 or WOX'],
                    'pluginOptions' => ['highlight' => true],
                    'dataset' => [
                        [
                            'remote' => Url::to(['gene/autocomplete']) . '&q=%QUERY',
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
    </div>

    <div id="no-results" style="display:none" class="alert alert-danger" role="alert">
        No results for this gene were found in this experiment.
    </div>

    <ul class="nav nav-tabs" id="experiments" role="tablist">
        <li data-toggle="tab">
            <a href="#start" data-exp="start" data-toggle="tooltip" data-original-title="Start here"><span class="glyphicon glyphicon-home"></span></a>
        </li>

        <li data-toggle="tab">
            <a href="#help" data-exp="help" data-toggle="tooltip" data-original-title="Quick Start Guide"><span class="glyphicon glyphicon-question-sign"></span></a>
        </li>

        <li data-toggle="tab">
            <a href="#intact" data-exp="intact" data-toggle="tooltip" data-original-title="Spatio-temporal transcriptome of cell type-specific nuclei">Cell type-specific</a>
        </li>

        <li data-toggle="tab" class="disabled">
            <a href="#" data-toggle="tooltip" data-original-title="Inhibition of MONOPTEROS (MP) and other Auxin Response Factors (ARFs) in the whole embryo">RPS5A>>bdl</a>
        </li>

        <?php if ( Yii::$app->user->isGuest === false ): ?>
        <li data-toggle="tab">
            <a href="#mpproper" data-exp="mpproper" data-toggle="tooltip" data-original-title="Inhibition of MONOPTEROS (MP) in ground and vascular tissue">Q0990>>bdl</a>
        </li>
        <li data-toggle="tab">
            <a href="#mpsuspensor" data-exp="mpsuspensor" data-toggle="tooltip" data-original-title="Inhibition of Auxin Response Factors (ARFs) in suspensor">M0107>>bdl</a>
        </li>

        <li data-toggle="tab">
            <a href="#rootgradient" data-exp="rootgradient" data-toggle="tooltip" data-original-title="FACS gradient of root">Root gradients</a>
        </li>

        <?php endif; ?>
        <li class="pull-right" id="spinner"><img src="/images/spinner.gif" alt="Loading" />Loading...</li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="start"></div>
        <div class="tab-pane active" id="help"></div>
        <div class="tab-pane active" id="intact"></div>
        <div class="tab-pane active" id="mpproper"></div>
        <div class="tab-pane active" id="mpsuspensor"></div>
        <div class="tab-pane active" id="rootgradient"></div>
    </div>
</div>
