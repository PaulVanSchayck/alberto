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

    'atlas_test' => [
        'login' => true,
        'template' => 'atlas_test.php',
        'loader' => 'loadExperiment',
        'experimentalSetup' => [
            'note' => 'Cell type-specific nuclei were isolated from early globular stage, late globular stage and heart stage Arabidopsis embryos...',
            'file' => 'atlas_test.md'
        ],
        'model' => 'app\models\Atlas_test',
        'images' => [
            'eg' => '.eg',
            'lg' => '.lg',
            'hs' => '.hs'
        ],
        'scales' => [
            'abs' => [
                'default' => [4,75],
                'max' => [0,200]
            ]
        ],
        'columns' => [

            // Absolute expression
            [
                'field' => 'nSUS_EG',
                'type' => 'abs',
                'label' => 'Suspensor EG'
            ],
            [
                'field' => 'nVSC_EG',
                'type' => 'abs',
                'label' => 'Vascular EG'
            ],
            [
                'field' => 'nEMB_EG',
                'type' => 'abs',
                'label' => 'Embryo EG'
            ],
            [
                'field' => 'nVSC_LG',
                'type' => 'abs',
                'label' => 'Vascular LG'
            ],
            [
                'field' => 'nEMB_LG',
                'type' => 'abs',
                'label' => 'Embryo LG'
            ],
            [
                'field' => 'nQC_TR_EH',
                'type' => 'abs',
                'label' => 'QC HS'
            ],

            // Spatial fold changes
            [
                'field' => 'FC_nVSC_EG_vs_nEMB_EG',
                'type' => 'fc_spt',
                'label' => 'Vascular/Embryo EG'
            ],
            [
                'field' => 'FC_nSUS_EG_vs_nEMB_EG',
                'type' => 'fc_spt',
                'label' => 'Suspensor/Embryo EG'
            ],
            [
                'field' => 'FC_nVSC_LG_vs_nEMB_LG',
                'type' => 'fc_spt',
                'label' => 'Vascular/Embryo LG'
            ],

            [
                'field' => 'FC_nQC_TR_EH_vs_nEMB_LG',
                'type' => 'fc_spt',
                'label' => 'QC HS/Embryo LG'
            ],

            // Temporal fold changes
            [
                'field' => 'FC_nVSC_LG_vs_nVSC_EG',
                'type' => 'fc_tmp',
                'label' => 'Vascular LG/Vascular EG'
            ],
            [
                'field' => 'FC_nEMB_LG_vs_nEMB_EG',
                'type' => 'fc_tmp',
                'label' => 'Embryo LG/Embryo EG'
            ],
            [
                'field' => 'FC_nQC_TR_EH_vs_nSUS_EG',
                'type' => 'fc_tmp',
                'label' => 'QC HS/Suspensor EG'
            ],
        ],

        // Rules for setting colors
        'rules' => [
            'eg' => [
                'suspensor' => [
                    'name' => 'Suspensor',
                    'abs' => 'nSUS_EG',
                    'rel' => 'nSUS_EG_rel',
                    'fc_spt' => 'FC_nSUS_EG_vs_nEMB_EG',
                    'fc_tmp' => false
                ],
                'hypophysis' => [
                    'name' => 'Hypophysis',
                    'abs' => 'nSUS_EG',
                    'rel' => 'nSUS_EG_rel',
                    'fc_spt' => 'FC_nSUS_EG_vs_nEMB_EG',
                    'fc_tmp' => false,
                ],
                'vascular-initials' => [
                    'name' => 'Vascular initials',
                    'abs' => 'nVSC_EG',
                    'rel' => 'nVSC_EG_rel',
                    'fc_spt' => 'FC_nVSC_EG_vs_nEMB_EG',
                    'fc_tmp' => false
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'nEMB_EG',
                    'rel' => 'nEMB_EG_rel',
                    'fc_spt' => false,
                    'fc_tmp' => false
                ]
            ],

            'lg' => [
                'vascular' => [
                    'name' => 'Vascular',
                    'abs' => 'nVSC_LG',
                    'rel' => 'nVSC_LG_rel',
                    'fc_spt' => 'FC_nVSC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nVSC_LG_vs_nVSC_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .vascular-initials'
                    ],
                ],
                'vascular-initials' => [
                    'name' => 'Vascular',
                    'abs' => 'nVSC_LG',
                    'rel' => 'nVSC_LG_rel',
                    'fc_spt' => 'FC_nVSC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nVSC_LG_vs_nVSC_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .vascular-initials'
                    ],
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'nEMB_LG',
                    'rel' => 'nEMB_LG_rel',
                    'fc_spt' => false,
                    'fc_tmp' => 'FC_nEMB_LG_vs_nEMB_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg'
                    ],
                ]
            ],

            'hs' => [
                'qc' => [
                    'name' => 'QC precursor',
                    'abs' => 'nQC_TR_EH',
                    'rel' => 'nQC_TR_EH_rel',
                    'fc_spt' => 'FC_nQC_TR_EH_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nQC_TR_EH_vs_nSUS_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .suspensor'
                    ],
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'no-data',
                    'rel' => 'no-data',
                    'fc_spt' => 'no-data',
                    'fc_tmp' => 'no-data'
                ]
            ]
        ]
    ],

    'atlas' => [
        'login' => true,
        'template' => 'atlas.php',
        'loader' => 'loadExperiment',
        'experimentalSetup' => [
            'note' => 'Cell type-specific nuclei were isolated from early globular stage, late globular stage and heart stage Arabidopsis embryos...',
            'file' => 'atlas.md'
        ],
        'model' => 'app\models\Atlas',
        'images' => [
            '16C' => '.wt-16C',
            'eg' => '.eg',
            'lg' => '.lg',
        ],
        'scales' => [
            'abs' => [
                'default' => [8,75],
                'max' => [0,200]
            ]
        ],
        'columns' => [

            // Absolute expression
            [
                'field' => 'nILT_16C',
                'type' => 'abs',
                'label' => 'Inner Lower Tier 16C'
            ],
            [
                'field' => 'nEMB_16C',
                'type' => 'abs',
                'label' => 'Embryo 16C'
            ],
            [
                'field' => 'nVSC_EG',
                'type' => 'abs',
                'label' => 'Vascular EG'
            ],
            [
                'field' => 'nGSC_EG',
                'type' => 'abs',
                'label' => 'Ground EG'
            ],
            [
                'field' => 'nSUS_EG',
                'type' => 'abs',
                'label' => 'Suspensor EG'
            ],
            [
                'field' => 'nEMB_EG',
                'type' => 'abs',
                'label' => 'Embryo EG'
            ],

            [
                'field' => 'nVSC_LG',
                'type' => 'abs',
                'label' => 'Vascular LG'
            ],

            [
                'field' => 'nGSC_LG',
                'type' => 'abs',
                'label' => 'Ground LG'
            ],

            [
                'field' => 'nSUS_LG',
                'type' => 'abs',
                'label' => 'Suspensor LG'
            ],

            [
                'field' => 'nQC_LG',
                'type' => 'abs',
                'label' => 'QC LG'
            ],

            [
                'field' => 'nEMB_LG',
                'type' => 'abs',
                'label' => 'Embryo LG'
            ],

            // Spatial fold changes
            [
                'field' => 'FC_nILT_16C_vs_nEMB_16C',
                'type' => 'fc_spt',
                'label' => 'ILT/Embryo 16C'
            ],
            [
                'field' => 'FC_nVSC_EG_vs_nEMB_EG',
                'type' => 'fc_spt',
                'label' => 'Vascular/Embryo EG'
            ],
            [
                'field' => 'FC_nGSC_EG_vs_nEMB_EG',
                'type' => 'fc_spt',
                'label' => 'Ground/Embryo EG'
            ],

            [
                'field' => 'FC_nSUS_EG_vs_nEMB_EG',
                'type' => 'fc_spt',
                'label' => 'Suspensor/Embryo EG'
            ],

            [
                'field' => 'FC_nVSC_LG_vs_nEMB_LG',
                'type' => 'fc_spt',
                'label' => 'Vascular/Embryo LG'
            ],
            [
                'field' => 'FC_nGSC_LG_vs_nEMB_LG',
                'type' => 'fc_spt',
                'label' => 'Ground/Embryo LG'
            ],
            [
                'field' => 'FC_nSUS_LG_vs_nEMB_LG',
                'type' => 'fc_spt',
                'label' => 'Suspensor/Embryo LG'
            ],

            [
                'field' => 'FC_nQC_LG_vs_nEMB_LG',
                'type' => 'fc_spt',
                'label' => 'QC/Embryo LG'
            ],


            // Temporal fold changes
            [
                'field' => 'FC_nEMB_EG_vs_nEMB_16C',
                'type' => 'fc_tmp',
                'label' => 'Embryo EG/Embryo 16C'
            ],
            [
                'field' => 'FC_nEMB_LG_vs_nEMB_EG',
                'type' => 'fc_tmp',
                'label' => 'Embryo LG/Embryo EG'
            ],
            [
                'field' => 'FC_nVSC_EG_vs_nILT_16C',
                'type' => 'fc_tmp',
                'label' => 'Vascular EG/Inner Lower Tier 16C'
            ],

            [
                'field' => 'FC_nVSC_LG_vs_nVSC_EG',
                'type' => 'fc_tmp',
                'label' => 'Vascular LG/Vascular EG'
            ],
            [
                'field' => 'FC_nGSC_EG_vs_nILT_16C',
                'type' => 'fc_tmp',
                'label' => 'Ground EG/Inner Lower Tier 16C'
            ],
            [
                'field' => 'FC_nGSC_LG_vs_nGSC_EG',
                'type' => 'fc_tmp',
                'label' => 'Ground LG/Ground EG'
            ],

            [
                'field' => 'FC_nSUS_LG_vs_nSUS_EG',
                'type' => 'fc_tmp',
                'label' => 'Suspensor LG/Suspensor EG'
            ]
        ],

        // Rules for setting colors
        'rules' => [
            'wt-16C' => [
                'inner-lower-tier' => [
                    'name' => 'Inner Lower Tier',
                    'abs' => 'nILT_16C',
                    'rel' => 'nILT_16C_rel',
                    'fc_spt' => 'FC_nILT_16C_vs_nEMB_16C',
                    'fc_tmp' => false
                ],
                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'nEMB_16C',
                    'rel' => 'nEMB_16C_rel',
                    'fc_spt' => false,
                    'fc_tmp' => false
                ]
            ],

            'eg' => [
                'suspensor' => [
                    'name' => 'Suspensor',
                    'abs' => 'nSUS_EG',
                    'rel' => 'nSUS_EG_rel',
                    'fc_spt' => 'FC_nSUS_EG_vs_nEMB_EG',
                    'fc_tmp' =>  'FC_nEMB_EG_vs_nEMB_16C',
                    'highlight' => [
                        'fc_tmp' => '.wt-16C'
                    ],
                ],
                'hypophysis' => [
                    'name' => 'Suspensor',
                    'abs' => 'nSUS_EG',
                    'rel' => 'nSUS_EG_rel',
                    'fc_spt' => 'FC_nSUS_EG_vs_nEMB_EG',
                    'fc_tmp' =>  'FC_nEMB_EG_vs_nEMB_16C',
                    'highlight' => [
                        'fc_tmp' => '.wt-16C'
                    ],
                ],
                'vascular-initials' => [
                    'name' => 'Vascular initials',
                    'abs' => 'nVSC_EG',
                    'rel' => 'nVSC_EG_rel',
                    'fc_spt' => 'FC_nVSC_EG_vs_nEMB_EG',
                    'fc_tmp' => 'FC_nVSC_EG_vs_nILT_16C',
                    'highlight' => [
                        'fc_tmp' => '.wt-16C .inner-lower-tier'
                    ],
                ],

                'ground-initials' => [
                    'name' => 'Ground tissue initials',
                    'abs' => 'nGSC_EG',
                    'rel' => 'nGSC_EG_rel',
                    'fc_spt' => 'FC_nGSC_EG_vs_nEMB_EG',
                    'fc_tmp' => 'FC_nGSC_EG_vs_nILT_16C',
                    'highlight' => [
                        'fc_tmp' => '.wt-16C .inner-lower-tier'
                    ],
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'nEMB_EG',
                    'rel' => 'nEMB_EG_rel',
                    'fc_spt' => false,
                    'fc_tmp' => 'FC_nEMB_EG_vs_nEMB_16C',
                    'highlight' => [
                        'fc_tmp' => '.wt-16C'
                    ],
                ]
            ],

            'lg' => [
                'vascular' => [
                    'name' => 'Vascular',
                    'abs' => 'nVSC_LG',
                    'rel' => 'nVSC_LG_rel',
                    'fc_spt' => 'FC_nVSC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nVSC_LG_vs_nVSC_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .vascular-initials'
                    ],

                ],
                'vascular-initials' => [
                    'name' => 'Vascular',
                    'abs' => 'nVSC_LG',
                    'rel' => 'nVSC_LG_rel',
                    'fc_spt' => 'FC_nVSC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nVSC_LG_vs_nVSC_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .vascular-initials'
                    ],

                ],
                'ground-initials' => [
                    'name' => 'Ground tissue initials',
                    'abs' => 'nGSC_LG',
                    'rel' => 'nGSC_LG_rel',
                    'fc_spt' => 'FC_nGSC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nGSC_LG_vs_nGSC_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .ground-initials'
                    ],
                ],
                'ground' => [
                    'name' => 'Ground tissue',
                    'abs' => 'nGSC_LG',
                    'rel' => 'nGSC_LG_rel',
                    'fc_spt' => 'FC_nGSC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nGSC_LG_vs_nGSC_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .ground-initials'
                    ],
                ],
                'qc' => [
                    'name' => 'QC precursor',
                    'abs' => 'nQC_LG',
                    'rel' => 'nQC_LG_rel',
                    'fc_spt' => 'FC_nQC_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nEMB_LG_vs_nEMB_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg'
                    ]
                ],
                'suspensor' => [
                    'name' => 'Suspensor',
                    'abs' => 'nSUS_LG',
                    'rel' => 'nSUS_LG_rel',
                    'fc_spt' => 'FC_nSUS_LG_vs_nEMB_LG',
                    'fc_tmp' => 'FC_nSUS_LG_vs_nSUS_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg .suspensor'
                    ],
                ],

                '*' => [
                    'name' => 'Whole embryo',
                    'abs' => 'nEMB_LG',
                    'rel' => 'nEMB_LG_rel',
                    'fc_spt' => false,
                    'fc_tmp' => 'FC_nEMB_LG_vs_nEMB_EG',
                    'highlight' => [
                        'fc_tmp' => '.eg'
                    ]
                ]
            ]
        ]
    ],

    'q0990' => [
        'login' => false,
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
        'login' => false,
        'template' => 'roots.php',
        'loader' => 'loadExperiment',
        'model' => 'app\models\RootGradient',
        'experimentalSetup' => [
            'note' => 'Cells from Arabidopsis roots expressing a gradient marker emanating from the distal root tip were sorted based on GFP intensity...',
            'file' => 'root-gradient.md'
        ],
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
                    'fc' => false
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
                    'fc' => false
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
                    'fc' => false
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
            ],
        ],
        'rules' => [
            'wt' => [
                '*' => [
                    'name' => 'Wild-type',
                    'abs' => 'wt',
                    'fc' => false
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
