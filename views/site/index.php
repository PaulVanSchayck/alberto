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
            <div class="col-lg-4">
                <h2>Early globular</h2>

                <p>
                    <svg id="eg" height="400"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?> ></svg>
                </p>

                <p><button class="btn btn-default" id="change">Change &raquo;</button></p>
            </div>
            <div class="col-lg-4">
                <h2>Late globular</h2>

                <p>
                    <svg id="lg" height="400"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?> ></svg>
                </p>

                <p><button class="btn btn-default" id="original">Original &raquo;</button></p>
            </div>
            <div class="col-lg-4">
                <h2>Heart stage</h2>

                <p>
                    <svg id="hs" height="600"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?> ></svg>
                </p>
            </div>
        </div>

    </div>
</div>
