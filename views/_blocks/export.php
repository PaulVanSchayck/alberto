<?php
use yii\bootstrap\Modal;

/* @var string $experiment */
?>

<?php Modal::begin([
    'id' => $experiment . '-exportModal',
    'header' => '<h4 class="modal-title">Export to CSV file</h4>',
    'toggleButton' => ['tag' => 'button', 'label' => 'CSV Export &raquo;', 'class' => 'btn btn-default'],
    'size' => Modal::SIZE_DEFAULT
]);?>
    <div class="exportModal">
        <p>
            <label>Export all columns:
                <input type="checkbox" class="visible">
            </label>
        </p>

        <p>Per default only columns visible in the current table are exported.</p>

        <p>
            <label>Maximum number of genes:
                <b class="badge">0</b>
                <input type="text" class="form-control ngenes" data-slider-min="0" data-slider-max="2000" data-slider-step="1" data-slider-value="1000" data-plugin-name="slider" title="Maximum number of genes">
                <b class="badge">2000</b>
            </label>
        </p>

        <p>The export is limited to 2000 genes. If you would like to view more genes in an export, you are
            recommended to download the full dataset and perform the filtering yourself.</p>

        <p>
            <label>Include annotations:
                <input type="checkbox" class="annotations">
            </label>
        </p>

        <p>The annotations increase the download size of the export significantly.</p>

        <p><button class="btn btn-primary export">Export &raquo;</button></p>
    </div>
<?php Modal::end(); ?>