<div class="row">
    <div class="col-lg-4">
        <h3>Early globular</h3>

        <div class="thumbnail">
            <svg id="eg"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?> ></svg>
        </div>
    </div>
    <div class="col-lg-4">
        <h3>Late globular</h3>

        <div class="thumbnail">
            <svg id="lg"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?> ></svg>
        </div>

    </div>
    <div class="col-lg-4">
        <h3>Heart stage</h3>

        <div class="thumbnail">
            <svg id="hs"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?> ></svg>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Scale</h3>
            </div>
            <div class="panel-body" id="scale">

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mode</h3>
            </div>
            <div class="panel-body" id="scale">

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Tools</h3>
            </div>
            <div class="panel-body" id="scale">
                <p><button class="btn btn-default" id="change">Test coloring &raquo;</button></p>
                <p><button class="btn btn-default" id="original">Original coloring &raquo;</button></p>
            </div>
        </div>
    </div>
</div>

<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>agi</th>
        <th>Gene</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>agi</th>
        <th>Gene</th>
        <th>Suspensor EG</th>
        <th>Vascular EG</th>
        <th>Whole embryo EG</th>
        <th>Vascular LG</th>
        <th>Whole embryo LG</th>
        <th>Hypophysis HS</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
