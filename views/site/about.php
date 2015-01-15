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
        The transcriptome data has been obtained by their respective researchers and they are shown in the
        experimental setup of the experiment.
    </p>

    <h2>Copyright and license</h2>

    <p>
        The source code of AlBERTO is <a href="https://github.com/PaulVanSchayck/alberto">available on GitHub</a>,
        copyright of Wageningen University and licensed under the GNU GPL v2 license.
    </p>

    <p>
        SVG images are copyright of (c) 2014 Wageningen University and licensed under the
        <a href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International
        License.</a>
    </p>

    <h2>Citations</h2>

    <p>Please cite the following article when using AlBERTO:</p>

    <p><i>To be published</i></p>
</div>
