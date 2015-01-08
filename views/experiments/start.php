
<h2>Welcome</h2>

<p>
    This is the AraBidopsis EmbRyonic Transcriptome brOwser (AlBERTO). You can directly start by entering a gene and
    selecting an experiment or by viewing the <a href="/index.php#nav-help" onclick="navInfo.setExperiment('help')">quick start guide</a>.
</p>

<h3>Available Experiments</h3>

<div class="container experiments">
    <div class="row">
        <div class="col-lg-2 experiment" data-toggle="tooltip" data-original-title="Transcriptome of individual cell types">
            <a href="/index.php#nav-intact" onclick="navInfo.setExperiment('intact')">
                <img src="images/start/intact.jpg">
                <span>Cell type-specific</span>
            </a>
        </div>

        <div class="col-lg-2 experiment" data-toggle="tooltip" data-original-title="FACS gradient of root">
            <a href="/index.php#nav-rootgradient" onclick="navInfo.setExperiment('rootgradient')">
                <img src="images/start/root.jpg">
                <span>Root gradients</span>
            </a>
        </div>

    </div>
</div>

<script type="application/javascript">
    $("#start div.experiment").tooltip({'placement': 'bottom'});
</script>