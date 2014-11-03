<?php
/* @var $this yii\web\View */
use kartik\widgets\Typeahead;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'AlBERTO';
?>
<div class="site-index">

    <div id="compability" style="display:none" class="alert alert-danger" role="alert">
        Your browser does not support all the features that this website requires, it will not function properly! Please update to a more modern browser.
    </div>

    <p>Enter an AT number or gene name and press show.</p>

    <form action="#" method="get" id="gene-show">
    <div class="row">
        <div class="col-lg-6">
            <div class="input-group at-input">
                <span class="input-group-addon">Gene</span>
                <?php
                $template = '<p>{{agi}} - {{gene}}</p>';
                echo Typeahead::widget([
                    'name' => 'gene',
                    'id' => 'gene',
                    'options' => ['placeholder' => 'AT1G01010 or WOX'],
                    'pluginOptions' => ['highlight' => true],
                    'dataset' => [
                        [
                            'remote' => Url::to(['gene/autocomplete']) . '&q=%QUERY',
                            'limit' => 10,
                            'templates' => [
                                'empty' => '<p>Unable to find a matching gene.</p>',
                                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                            ],
                            'displayKey' => 'agi'
                        ]
                    ]
                ]);
                ?>
                <span class="input-group-btn">
                    <input type="submit" class="btn btn-default btn-info" value="Show" />
                </span>
            </div>
        </div>
    </div>
    </form>

    <ul class="nav nav-tabs" id="experiments" role="tablist">
        <li data-toggle="tab">
            <a href="#intact" data-exp="intact" data-toggle="tooltip" data-original-title="Transcriptome of individual cell types">Embryonic cell types</a>
        </li>
        <li data-toggle="tab">
            <a href="#mp" data-exp="mp" data-toggle="tooltip" data-original-title="Transcriptome of MP mutant compared to WT"><i>Monopteros</i> mutants transcriptome</a>
        </li>
        <li data-toggle="tab" class="disabled">
            <a href="#" data-toggle="tooltip" data-original-title="FACS gradient of root">Root gradients</a>
        </li>
        <li class="pull-right" id="spinner"><img src="/images/spinner.gif" alt="Loading" />Loading...</li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="intact"></div>
        <div class="tab-pane active" id="mp"></div>
    </div>
</div>
