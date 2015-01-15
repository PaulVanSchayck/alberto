<?php
return [
    'start' => [
        'login' => false,
        'template' => 'start.php',
        'loader' => 'loadStart'
    ],

    'help' => [
        'login' => false,
        'template' => 'help.php',
        'loader' => 'loadStart'
    ],

    'intact' => [
        'login' => true,
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
        'login' => true,
        'template' => 'monopteros.php',
        'loader' => 'loadExperiment',
        'model' => 'app\models\MpProper',
        'images' => [
            'wtlg' => '.wt .lg',
            'mplg' => '.mp .lg',
            'wths' => '.wt .hs',
            'mphs' => '.mp .hs'
        ],
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
                'type' => 'fc',
                'label' => 'FC1'
            ],
        ],
        'rules' => [
            'wtlg' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'c1',
                    'fc' => 'no-data'
                ]
            ],
            'mplg' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'e1',
                    'fc' => 'fc1'
                ]
            ],
            'wths' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'no-data',
                    'fc' => 'no-data'
                ]
            ],
            'mphs' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'no-data',
                    'fc' => 'no-data'
                ]
            ]
        ]
    ],

    'rootgradient' => [
        'login' => true,
        'template' => 'roots.php',
        'loader' => 'loadExperiment',
        'model' => 'app\models\RootGradient',
        'images' => [
            'tmo5' => '.tmo5 .root',
            'spt' => '.spt .root',
            'pub25' => '.pub25 .root',
        ],
        'columns' => [
            [
                'field' => 'spt_h',
                'type' => 'abs',
                'label' => 'SPT High'
            ],
            [
                'field' => 'spt_m',
                'type' => 'abs',
                'label' => 'SPT Medium'
            ],
            [
                'field' => 'spt_l',
                'type' => 'abs',
                'label' => 'SPT Low'
            ],

            [
                'field' => 'pub25_h',
                'type' => 'abs',
                'label' => 'PUB25 High'
            ],
            [
                'field' => 'pub25_m',
                'type' => 'abs',
                'label' => 'PUB25 Medium'
            ],
            [
                'field' => 'pub25_l',
                'type' => 'abs',
                'label' => 'PUB25 Low'
            ],

            [
                'field' => 'tmo5_h',
                'type' => 'abs',
                'label' => 'TMO5 High'
            ],
            [
                'field' => 'tmo5_m',
                'type' => 'abs',
                'label' => 'TMO5 Medium'
            ],
            [
                'field' => 'tmo5_l',
                'type' => 'abs',
                'label' => 'TMO5 Low'
            ],


            // Fold changes

            [
                'field' => 'fc_spt_hm',
                'type'  => 'fc',
                'label' => 'FC SPT Medium/High'
            ],
            [
                'field' => 'fc_spt_ml',
                'type'  => 'fc',
                'label' => 'FC SPT Low/Medium'
            ],
            [
                'field' => 'fc_spt_hl',
                'type'  => 'fc',
                'label' => 'FC SPT Low/High'
            ],

            [
                'field' => 'fc_pub25_hm',
                'type'  => 'fc',
                'label' => 'FC PUB25 Medium/High'
            ],
            [
                'field' => 'fc_pub25_ml',
                'type'  => 'fc',
                'label' => 'FC PUB25 Low/Medium'
            ],
            [
                'field' => 'fc_pub25_hl',
                'type'  => 'fc',
                'label' => 'FC PUB25 Low/High'
            ],

            [
                'field' => 'fc_tmo5_hm',
                'type'  => 'fc',
                'label' => 'FC TMO5 Medium/High'
            ],
            [
                'field' => 'fc_tmo5_ml',
                'type'  => 'fc',
                'label' => 'FC TMO5 Low/Medium'
            ],
            [
                'field' => 'fc_tmo5_hl',
                'type'  => 'fc',
                'label' => 'FC TMO5 Low/High'
            ],



        ],
        'rules' => [
            'spt' => [
                'high' => [
                    'name' => 'High',
                    'abs' => 'spt_h',
                    'fc' => 'no-data'
                ],
                'medium' => [
                    'name' => 'Medium',
                    'abs' => 'spt_m',
                    'fc' => 'fc_spt_ml'
                ],
                'low' => [
                    'name' => 'Low',
                    'abs' => 'spt_l',
                    'fc' => 'fc_spt_hl'
                ],
            ],
            'pub25' => [
                'high' => [
                    'name' => 'High',
                    'abs' => 'pub25_h',
                    'fc' => 'no-data'
                ],
                'medium' => [
                    'name' => 'Medium',
                    'abs' => 'pub25_m',
                    'fc' => 'fc_pub25_ml'
                ],
                'low' => [
                    'name' => 'Low',
                    'abs' => 'pub25_l',
                    'fc' => 'fc_pub25_hl'
                ],
            ],
            'tmo5' => [
                'high' => [
                    'name' => 'High',
                    'abs' => 'tmo5_h',
                    'fc' => 'no-data'
                ],
                'medium' => [
                    'name' => 'Medium',
                    'abs' => 'tmo5_m',
                    'fc' => 'fc_tmo5_ml'
                ],
                'low' => [
                    'name' => 'Low',
                    'abs' => 'tmo5_l',
                    'fc' => 'fc_tmo5_hl'
                ],
            ]
        ]
    ]
];
