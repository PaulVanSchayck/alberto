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

    <ul class="nav nav-tabs" role="tablist">
        <li class="active" data-toggle="tab"><a href="#">INTACT</a></li>
        <li><a href="#"><i>MP</i> mutants</a></li>
        <li class="disabled"><a href="#">Root gradients</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div class="row">
                <div class="col-lg-4">
                    <h2>Early globular</h2>

                    <div class="thumbnail">
                        <svg id="eg" height="400"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?> ></svg>
                    </div>

                    <p><button class="btn btn-default" id="change">Change &raquo;</button></p>
                </div>
                <div class="col-lg-4">
                    <h2>Late globular</h2>

                    <div class="thumbnail">
                        <svg id="lg" height="400"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?> ></svg>
                    </div>

                    <p><button class="btn btn-default" id="original">Original &raquo;</button></p>
                </div>
                <div class="col-lg-4">
                    <h2>Heart stage</h2>

                    <div class="thumbnail">
                        <svg id="hs" height="400"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?> ></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
