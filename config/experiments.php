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
                'label' => 'Vascular/Embryo EG'
            ],
            [
                'field' => 'fc_suspensor_eg_embryo_eg',
                'type' => 'fc_spt',
                'label' => 'Suspensor/Embryo EG'
            ],
            [
                'field' => 'fc_vascular_lg_embryo_lg',
                'type' => 'fc_spt',
                'label' => 'Vascular/Embryo LG'
            ],

            [
                'field' => 'fc_qc_hs_embryo_lg',
                'type' => 'fc_spt',
                'label' => 'QC HS/Embryo LG'
            ],

            // Temporal fold changes
            [
                'field' => 'fc_vascular_lg_vascular_eg',
                'type' => 'fc_tmp',
                'label' => 'Vascular LG/Vascular EG'
            ],
            [
                'field' => 'fc_embryo_lg_embryo_eg',
                'type' => 'fc_tmp',
                'label' => 'Embryo LG/Embryo EG'
            ],
            [
                'field' => 'fc_qc_hs_suspensor_eg',
                'type' => 'fc_tmp',
                'label' => 'QC HS / Suspensor EG'
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
                    'fc_spt' => 'fc_qc_hs_embryo_lg',
                    'fc_tmp' => 'fc_qc_hs_suspensor_eg'
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'no-data',
                    'fc_spt' => false,
                    'fc_tmp' => false
                ]
            ]
        ]
    ],

    'q0990' => [
        'login' => true,
        'template' => 'monopteros.php',
        'loader' => 'loadExperiment',
        'model' => 'app\models\q0990',
        'images' => [
            'mpgl' => '.eg-lg .embryo',
            'mphs' => '.hs .embryo',
        ],
        'columns' => [
            [
                'field' => 'fc_day3',
                'type' => 'fc',
                'label' => '3 days'
            ],
            [
                'field' => 'fc_day6',
                'type' => 'fc',
                'label' => '6 days'
            ],
        ],
        'rules' => [
            'mpgl' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'fc' => 'fc_day3'
                ]
            ],
            'mphs' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'fc' => 'fc_day6'
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
                'label' => 'SPT Medium/High'
            ],
            [
                'field' => 'fc_spt_ml',
                'type'  => 'fc',
                'label' => 'SPT Low/Medium'
            ],
            [
                'field' => 'fc_spt_hl',
                'type'  => 'fc',
                'label' => 'SPT Low/High'
            ],

            [
                'field' => 'fc_pub25_hm',
                'type'  => 'fc',
                'label' => 'PUB25 Medium/High'
            ],
            [
                'field' => 'fc_pub25_ml',
                'type'  => 'fc',
                'label' => 'PUB25 Low/Medium'
            ],
            [
                'field' => 'fc_pub25_hl',
                'type'  => 'fc',
                'label' => 'PUB25 Low/High'
            ],

            [
                'field' => 'fc_tmo5_hm',
                'type'  => 'fc',
                'label' => 'TMO5 Medium/High'
            ],
            [
                'field' => 'fc_tmo5_ml',
                'type'  => 'fc',
                'label' => 'TMO5 Low/Medium'
            ],
            [
                'field' => 'fc_tmo5_hl',
                'type'  => 'fc',
                'label' => 'TMO5 Low/High'
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
                    'fc' => 'fc_spt_hm'
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
                    'fc' => 'fc_pub25_hm'
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
                    'fc' => 'fc_tmo5_hm'
                ],
                'low' => [
                    'name' => 'Low',
                    'abs' => 'tmo5_l',
                    'fc' => 'fc_tmo5_hl'
                ],
            ]
        ]
    ],

    'eightcell' => [
        'login' => true,
        'template' => 'default.php',
        'model' => 'app\models\EightCell',
        'images' => [
            'wt' => '.eight-wt',
            'mt' => '.eight-rps5a',
        ],
        'columns' => [
            [
                'field' => 'wt',
                'type' => 'abs',
                'label' => 'Wild-type'
            ],
            [
                'field' => 'bdl',
                'type' => 'abs',
                'label' => 'RPS5A>>bdl'
            ],

            // Fold change
            [
                'field' => 'fc_bdl_wt',
                'type' => 'fc',
                'label' => 'RPS5A>>bdl/Wild-type'
            ]
        ],
        'rules' => [
            'wt' => [
                '*' => [
                    'name' => 'Wild-type',
                    'abs' => 'wt',
                    'fc' => 'no-data'
                ]
            ],
            'mt' => [
                '*' => [
                    'name' => 'RPS5A>>bdl',
                    'abs' => 'bdl',
                    'fc' => 'fc_bdl_wt'
                ]
            ]
        ]
    ]
];
