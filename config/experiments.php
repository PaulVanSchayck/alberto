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

            // Absolute expression
            [
                'field' => 'suspensor_eg',
                'type' => 'abs',
                'label' => 'Suspensor EG'
            ],
            [
                'field' => 'vascular_eg',
                'type' => 'abs',
                'label' => 'Vascular EG'
            ],
            [
                'field' => 'embryo_eg',
                'type' => 'abs',
                'label' => 'Embryo EG'
            ],
            [
                'field' => 'vascular_lg',
                'type' => 'abs',
                'label' => 'Vascular LG'
            ],
            [
                'field' => 'embryo_lg',
                'type' => 'abs',
                'label' => 'Embryo LG'
            ],
            [
                'field' => 'qc_hs',
                'type' => 'abs',
                'label' => 'QC HS'
            ],

            // Spatial fold changes
            [
                'field' => 'fc_vascular_eg_embryo_eg',
                'type' => 'fc',
                'label' => 'FC Vascular/Embryo EG'
            ],
            [
                'field' => 'fc_suspensor_eg_embryo_eg',
                'type' => 'fc',
                'label' => 'FC Suspensor/Embryo EG'
            ],
            [
                'field' => 'fc_vascular_lg_embryo_lg',
                'type' => 'fc',
                'label' => 'FC Vascular/Embryo LG'
            ],

            // Temporal fold changes
            [
                'field' => 'fc_vascular_lg_vascular_eg',
                'type' => 'fc_tmp',
                'label' => 'FC Vascular LG/Vascular EG'
            ],
            [
                'field' => 'fc_embryo_lg_embryo_eg',
                'type' => 'fc_tmp',
                'label' => 'FC Embryo LG/Embryo EG'
            ],
        ]
    ]
];
