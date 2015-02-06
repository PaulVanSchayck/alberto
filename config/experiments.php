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
                'label' => 'QC HS/Suspensor EG'
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
                'hypophysis' => [
                    'name' => 'Hypophysis',
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
                    'fc_spt' => 'no-data',
                    'fc_tmp' => 'no-data'
                ]
            ]
        ]
    ],

    'q0990' => [
        'login' => true,
        'template' => 'monopteros.php',
        'loader' => 'loadExperiment',
        'experimentalSetup' => [
            'note' => 'MONOPTEROS (MP) is inhibited in the inner embryo proper cells of early Q0990>>bdl embryos...',
            'file' => 'Q0990.md'
        ],
        'note' => 'This dataset only contains significant differentially expressed genes (see experimental setup).',
        'model' => 'app\models\q0990',
        'images' => [
            'mpgl' => [
                'selector' => '.mpgl .embryo',
                'file' => 'eg_lg_Q0990.svg',
                'label' => 'Globular stage (Q0990>>bdl)'
            ],
            'mphs' => [
                'selector' => '.mphs .embryo',
                'file' => 'hs_Q0990.svg',
                'label' => 'Heart stage (Q0990>>bdl)'
            ]
        ],
        'columns' => [
            [
                'field' => 'fc_day3',
                'type' => 'fc',
                'label' => 'Q0990>>bdl/Wild-type Globular'
            ],
            [
                'field' => 'fc_day6',
                'type' => 'fc',
                'label' => 'Q0990>>bdl/Wild-type HS'
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

    'm0171' => [
        'login' => true,
        'template' => 'monopteros.php',
        'loader' => 'loadExperiment',
        'experimentalSetup' => [
            'note' => 'Auxin response factors (ARFs) are inhibited in the suspensor cells of early M0171>>bdl Arabidopsis embryos...',
            'file' => 'M0171.md'
        ],
        'note' => 'This dataset only contains significant differentially expressed genes (see experimental setup).',
        'model' => 'app\models\m0171',
        'images' => [
            'mpgl' => [
                'selector' => '.mpgl .embryo',
                'file' => 'eg_lg_M0171.svg',
                'label' => 'Globular stage (M0171>>bdl)'
            ]
        ],
        'columns' => [
            [
                'field' => 'fc_day3',
                'type' => 'fc',
                'label' => 'M0171>>bdl/Wild-type Globular'
            ],
        ],
        'rules' => [
            'mpgl' => [
                '*' => [
                    'name' => 'Whole embryo',
                    'fc' => 'fc_day3'
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
                'label' => 'SPT Proximal'
            ],
            [
                'field' => 'spt_m',
                'type' => 'abs',
                'label' => 'SPT Medial'
            ],
            [
                'field' => 'spt_l',
                'type' => 'abs',
                'label' => 'SPT Distal'
            ],

            [
                'field' => 'pub25_h',
                'type' => 'abs',
                'label' => 'PUB25 Proximal'
            ],
            [
                'field' => 'pub25_m',
                'type' => 'abs',
                'label' => 'PUB25 Medial'
            ],
            [
                'field' => 'pub25_l',
                'type' => 'abs',
                'label' => 'PUB25 Distal'
            ],

            [
                'field' => 'tmo5_h',
                'type' => 'abs',
                'label' => 'TMO5 Proximal'
            ],
            [
                'field' => 'tmo5_m',
                'type' => 'abs',
                'label' => 'TMO5 Medial'
            ],
            [
                'field' => 'tmo5_l',
                'type' => 'abs',
                'label' => 'TMO5 Distal'
            ],


            // Fold changes

            [
                'field' => 'fc_spt_hm',
                'type'  => 'fc',
                'label' => 'SPT Medial/Proximal'
            ],
            [
                'field' => 'fc_spt_ml',
                'type'  => 'fc',
                'label' => 'SPT Distal/Medial'
            ],
            [
                'field' => 'fc_spt_hl',
                'type'  => 'fc',
                'label' => 'SPT Distal/Proximal'
            ],

            [
                'field' => 'fc_pub25_hm',
                'type'  => 'fc',
                'label' => 'PUB25 Medial/Proximal'
            ],
            [
                'field' => 'fc_pub25_ml',
                'type'  => 'fc',
                'label' => 'PUB25 Distal/Medial'
            ],
            [
                'field' => 'fc_pub25_hl',
                'type'  => 'fc',
                'label' => 'PUB25 Distal/Proximal'
            ],

            [
                'field' => 'fc_tmo5_hm',
                'type'  => 'fc',
                'label' => 'TMO5 Medial/Proximal'
            ],
            [
                'field' => 'fc_tmo5_ml',
                'type'  => 'fc',
                'label' => 'TMO5 Distal/Medial'
            ],
            [
                'field' => 'fc_tmo5_hl',
                'type'  => 'fc',
                'label' => 'TMO5 Distal/Proximal'
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
        'experimentalSetup' => [
            'note' => 'MONOPTEROS (MP) and other auxin response factors (ARFs) are inhibited in early RPS5A>>bdl Arabidopsis embryos...',
            'file' => 'rps5a.md'
        ],
        'model' => 'app\models\EightCell',
        'images' => [
            'wt' => '.eight-wt',
            'mt' => '.eight-rps5a',
        ],
        'scales' => [
            'fc' => [
                'default' => [-5,5],
                'max' => [-10,10]
            ],
            'abs' => [
                'default' => [0,300],
                'max' => [0,1000]
            ]
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
