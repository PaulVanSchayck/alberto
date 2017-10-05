


<div class="container experiments">
    <div class="row" >
        <div id="select-experiment" style="display: none;" class="alert alert-warning">
            Select an experiment in the tabs above
        </div>
    </div>

    <div class="row">
        <div class="alert alert-welcome col-lg-2">
            <h4>Welcome</h4>
            This is the AraBidopsis Embryonic and Root Transcriptome brOwser (AlBERTO). You can directly start by entering a gene and
            selecting an experiment or by viewing the <a href="#" onclick="event.preventDefault();navInfo.setExperiment('help')">quick start guide</a>.
        </div>

        <?php if ( Yii::$app->user->isGuest === false ): ?>

        <div class="col-lg-2 experiment">
            <a href="#" onclick="event.preventDefault();navInfo.setExperiment('atlas')">
                <img src="/images/start/intact.png">
            </a>
            <div class="experiment-description">
                <h4><a href="#t" onclick="event.preventDefault();navInfo.setExperiment('atlas_')">Cell type-specific</a></h4>
                <p>Spatio-temporal transcriptomes of cell type-specific nuclei in the early embryo</p>
            </div>
        </div>

        <div class="col-lg-2 experiment">
            <a href="#" onclick="event.preventDefault();navInfo.setExperiment('atlas_test')">
                <img src="/images/start/intact.png">
            </a>
            <div class="experiment-description">
                <h4><a href="#t" onclick="event.preventDefault();navInfo.setExperiment('atlas_test')">Cell type-specific (test)</a></h4>
                <p>Spatio-temporal transcriptomes of cell type-specific nuclei in the early embryo</p>
            </div>
        </div>

        <div class="col-lg-2 experiment" data-toggle="tooltip">
            <a href="#" onclick="event.preventDefault();navInfo.setExperiment('eightcell')">
                <img src="/images/start/rps5a.png">
            </a>
            <div class="experiment-description">
                <h4><a href="#" onclick="event.preventDefault();navInfo.setExperiment('eightcell')">RPS5A>>bdl</a></h4>
                <p>Inhibition of MONOPTEROS and other auxin response factors in the whole octant embryo</p>
            </div>
        </div>

        <div class="col-lg-2 experiment" data-toggle="tooltip">
            <a href="#" onclick="event.preventDefault();navInfo.setExperiment('q0990')">
                <img src="/images/start/q0990.png">
            </a>
            <div class="experiment-description">
                <h4><a href="#" onclick="event.preventDefault();navInfo.setExperiment('q0990')">Q0990>>bdl</a></h4>
                <p>Inhibition of MONOPTEROS in ground and vascular tissue in the early embryo</p>
            </div>
        </div>

        <div class="col-lg-2 experiment" data-toggle="tooltip">
            <a href="#" onclick="event.preventDefault();navInfo.setExperiment('m0171')">
                <img src="/images/start/m0171.png">
            </a>
            <div class="experiment-description">
                <h4><a href="#" onclick="event.preventDefault();navInfo.setExperiment('m0171')">M0171>>bdl</a></h4>
                <p>Inhibition of auxin response factors in the suspensor in the globular embryo</p>
            </div>
        </div>

        <div class="col-lg-2 experiment" data-toggle="tooltip">
            <a href="#" onclick="event.preventDefault();navInfo.setExperiment('rootgradient')">
                <img src="/images/start/root.jpg">
            </a>
            <div class="experiment-description">
                <h4><a href="#" onclick="event.preventDefault();navInfo.setExperiment('rootgradient')">Root gradients</a></h4>
                <p>RNAseq data of differentially sorted root cells based on GFP gradient markers</p>
            </div>
        </div>
        <?php endif ?>

    </div>
</div>

<script type="application/javascript">
    navInfo.registerExperiment(noExperiment());
</script>