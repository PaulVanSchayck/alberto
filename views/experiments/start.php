
<h2></h2>

<div class="row">

</div>

<div class="container experiments">
    <div class="row">
        <div class="alert alert-success col-lg-2">
            <h4>Welcome</h4>
            This is the AraBidopsis Embryonic and Root Transcriptome brOwser (AlBERTO). You can directly start by entering a gene and
            selecting an experiment or by viewing the <a href="/index.php#nav-help" onclick="navInfo.setExperiment('help')">quick start guide</a>.
        </div>
        <div class="col-lg-1 experiment">
            <a href="/index.php#nav-intact" onclick="navInfo.setExperiment('intact')">
                <img src="images/start/intact.png">
            </a>
            <div class="experiment-description">
                <h4><a href="/index.php#nav-intact" onclick="navInfo.setExperiment('intact')">Cell type-specific</a></h4>
                <p>Transcriptome of individual cell types</p>
            </div>
        </div>

        <div class="col-lg-1 experiment" data-toggle="tooltip">
            <a href="/index.php#nav-rootgradient" onclick="navInfo.setExperiment('rootgradient')">
                <img src="images/start/root.jpg">
                <span></span>
            </a>
            <div class="experiment-description">
                <h4><a href="/index.php#nav-rootgradient" onclick="navInfo.setExperiment('rootgradient')">Root gradients</a></h4>
                <p>FACS gradient of root</p>
            </div>
        </div>

        <div class="col-lg-1 experiment" data-toggle="tooltip">
            <a href="/index.php#nav-eightcell" onclick="navInfo.setExperiment('eightcell')">
                <img src="images/start/rps5a.png">
                <span></span>
            </a>
            <div class="experiment-description">
                <h4><a href="/index.php#nav-eightcell" onclick="navInfo.setExperiment('eightcell')">RPS5A>>bdl</a></h4>
                <p>Inhibition of MONOPTEROS in the octant embryo</p>
            </div>
        </div>

    </div>
</div>

<script type="application/javascript">
    $("#start div.experiment").tooltip({'placement': 'bottom'});
</script>