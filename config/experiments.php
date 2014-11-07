<?php
return [
    'start' => [
        'template' => 'start.php',
        'loader' => 'loadStart'
    ],

    'intact' => [
        'template' => 'intact.php',
        'loader' => 'loadExperiment',
        'columns' => [
            [
                'field' => 'suspensor_eg',
                'label' => 'Suspensor EG'
            ],
            [
                'field' => 'vascular_eg',
                'label' => 'Vascular EG'
            ],
            [
                'field' => 'embryo_eg',
                'label' => 'Vascular EG'
            ],
            [
                'field' => 'vascular_lg',
                'label' => 'Vascular LG'
            ],
            [
                'field' => 'embryo_lg',
                'label' => 'Embryo LG'
            ],
            [
                'field' => 'qc_hs',
                'label' => 'QC HS'
            ]
        ]
    ]
];
