<?php
return [
    'start' => [
        'template' => 'start.php',
        'loader' => 'loadStart'
    ],

    'intact' => [
        'template' => 'intact.php',
        'loader' => 'loadExperiment',
        'model' => 'app\models\Intact',
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
                'type' => 'fc_spt',
                'label' => 'FC Vascular/Embryo EG'
            ],
            [
                'field' => 'fc_suspensor_eg_embryo_eg',
                'type' => 'fc_spt',
                'label' => 'FC Suspensor/Embryo EG'
            ],
            [
                'field' => 'fc_vascular_lg_embryo_lg',
                'type' => 'fc_spt',
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
            [
                'field' => 'fc_qc_hs_suspensor_eg',
                'type' => 'fc_tmp',
                'label' => 'FC QC HS / Suspensor EG'
            ],
        ],

        // Rules for setting colors
        'rules' => [
            'eg' => [
                'suspensor' => [
                    'name' => 'Suspensor',
                    'abs' => 'suspensor_eg',
                    'fc_spt' => 'fc_suspensor_eg_embryo_eg',
                    'fc_tmp' => false
                ],
                'vascular-initials' => [
                    'name' => 'Vascular initials',
                    'abs' => 'vascular_eg',
                    'fc_spt' => 'fc_vascular_eg_embryo_eg',
                    'fc_tmp' => false
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'embryo_eg',
                    'fc_spt' => false,
                    'fc_tmp' => false
                ]
            ],

            'lg' => [
                'vascular' => [
                    'name' => 'Vascular',
                    'abs' => 'vascular_lg',
                    'fc_spt' => 'fc_vascular_lg_embryo_lg',
                    'fc_tmp' => 'fc_vascular_lg_vascular_eg'
                ],
                'vascular-initials' => [
                    'name' => 'Vascular',
                    'abs' => 'vascular_lg',
                    'fc_spt' => 'fc_vascular_lg_embryo_lg',
                    'fc_tmp' => 'fc_vascular_lg_vascular_eg'
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'embryo_lg',
                    'fc_spt' => false,
                    'fc_tmp' => 'fc_embryo_lg_embryo_eg'
                ]
            ],

            'hs' => [
                'qc' => [
                    'name' => 'QC',
                    'abs' => 'qc_hs',
                    'fc_spt' => 'no-data',
                    'fc_tmp' => 'fc_qc_hs_suspensor_eg'
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'no-data',
                    'fc_spt' => 'no-data',
                    'fc_tmp' => 'no-data'
                ]
            ]
        ]
    ],

    'mpproper' => [
        'template' => 'monopteros.php',
        'loader' => 'loadExperiment',
        'model' => 'app\models\MpProper',
        'columns' => [
            [
                'field' => 'c1',
                'type' => 'abs',
                'label' => 'C1'
            ],
            [
                'field' => 'e1',
                'type' => 'abs',
                'label' => 'E1'
            ],
            [
                'field' => 'fc1',
                'type' => 'abs',
                'label' => 'FC1'
            ],

        ]
    ]
];
