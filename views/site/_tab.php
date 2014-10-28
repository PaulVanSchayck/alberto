<div class="row">
    <div class="col-lg-4">
        <h3>Early globular</h3>

        <div class="thumbnail">
            <svg id="eg"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/eg-plain.svg'); ?> ></svg>
        </div>

        <p><button class="btn btn-default" id="change">Change &raquo;</button></p>
    </div>
    <div class="col-lg-4">
        <h3>Late globular</h3>

        <div class="thumbnail">
            <svg id="lg"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/lg-plain.svg'); ?> ></svg>
        </div>

        <p><button class="btn btn-default" id="original">Original &raquo;</button></p>
    </div>
    <div class="col-lg-4">
        <h3>Heart stage</h3>

        <div class="thumbnail">
            <svg id="hs"><?= file_get_contents(Yii::getAlias('@app') . '/svg/optimized/hs-plain.svg'); ?> ></svg>
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
