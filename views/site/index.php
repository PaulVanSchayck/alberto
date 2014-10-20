<?php
/* @var $this yii\web\View */
$this->title = 'AlBERTO';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>AlBERTO</h1>

        <p class="lead">AraBidopsis EmbRyonic Transcriptome brOwser</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>Late globular</h2>

                <p>
                    <svg id="lg" height="600"><?= file_get_contents(Yii::getAlias('@webroot') . '/svg/lg-plain.svg'); ?> ></svg>
                </p>

                <p><button class="btn btn-default" id="change">Change &raquo;</button></p>
            </div>
        </div>

    </div>
</div>
