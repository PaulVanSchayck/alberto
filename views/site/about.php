<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        The AraBidopsis EmbRyonic Transcriptome brOwser (AlBERTO) is a feature rich web-based tool which gives
        researcher insight in complex transcriptomic data. It paints diagrammatic representation of
        (parts of) <i>Arabidopsis thaliana</i> with relevant transcriptomic data. Additionally, you can filter
        and export this data.
    </p>

    <h2>Help</h2>

    <p>The <a href="<?=\yii\helpers\Url::to(['site/index']); ?>#nav-help">quick start guide</a> can help you with getting to know the basic features of the browser.</p>

    <h2>Authors</h2>

    <p>AlBERTO was programmed by Paul van Schayck.</p>

    <p>The vector images of the embryos were created by Colette Ten Hove and Kuan-Ju Lu.</p>

    <p>
        The transcriptome data has been obtained by their respective researchers and can be viewed in the experimental
        setup of the experiment.
    </p>

    <h2>Citations</h2>

    <p>Please cite the following article when using AlBERTO:</p>

    <p><i>To be written...</i></p>
</div>
