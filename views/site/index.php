<?php
/* @var $this yii\web\View */
$this->title = 'AlBERTO';
?>
<div class="site-index">

    <p>Enter your AT number and press search.</p>

    <div class="row">
        <div class="col-lg-6">
            <div class="input-group at-input">
                <span class="input-group-addon">AT</span>
                <input type="text" class="form-control" placeholder="At1g01010">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-info" type="button">Search</button>
              </span>
            </div>
        </div>
    </div>

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
