<div class="row svg-images">
    <div class="col-lg-4">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Early globular</h3>
            </div>
            <div class="panel-body svg">
                <svg id="eg"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?> ></svg>
            </div>
        </div>

    </div>
    <div class="col-lg-4">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Late globular</h3>
            </div>
            <div class="panel-body svg">
                <svg id="lg"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?> ></svg>
            </div>
        </div>

    </div>
    <div class="col-lg-4">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Heart stage</h3>
            </div>
            <div class="panel-body svg">
                <svg id="hs"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?> ></svg>
            </div>
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

<table id="example" class="display">
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
