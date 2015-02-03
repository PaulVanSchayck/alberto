<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        The AraBidopsis Embryonic and Root Transcriptome brOwser (AlBERTO) is a feature rich web-based tool which gives
        researchers insight into complex spatio-temporal transcriptomic data in <i>Arabidopsis thaliana</i>. By using diagrammatic
        representations of different tissues and cell types relevant transcriptomic data can be displayed, filtered and exported.
    </p>

    <h2>Help</h2>

    <p>The <a href="<?=\yii\helpers\Url::to(['site/index']); ?>#nav-help">quick start guide</a> can help you with getting to know the basic features of the browser.</p>

    <h2>Reporting problems and feedback</h2>

    <p>
        We would like to hear about any problems you encounter.
        View the <a href="<?=\yii\helpers\Url::to(['site/contact']);?>">contact page</a> for contact details.
    </p>

    <h2>Annotations</h2>

    <p>The annotations have been generated from
        <a href="http://brainarray.mbni.med.umich.edu/Brainarray/Database/CustomCDF/18.0.0/tairg.asp">MBNI</a>
        custom CDF files. Specifically of aragene10st_At_TAIRG.</p>

    <h2>Authors</h2>

    <p>AlBERTO was programmed by Paul van Schayck with feedback from Joakim Palovaara.</p>

    <p>The vector images of embryos were created by Colette Ten Hove and Kuan-Ju Lu while the vector images of roots
        were created by Jos R. Wendrich.</p>

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
