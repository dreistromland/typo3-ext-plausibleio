<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Plausible.io',
    'description'      => 'Privacy-friendly analytics integration for TYPO3 CMS. Analyze your audience with Plausible Analytics and see nice dashboards with analytics data directly in the TYPO3 backend.',
    'category'         => 'backend',
    'author'           => 'dreistrom.land AG',
    'author_email'     => 'hello@dreistrom.land',
    'author_company'   => 'dreistrom.land AG',
    'state'            => 'stable',
    'uploadfolder'     => '0',
    'clearCacheOnLoad' => 1,
    'version'          => '3.0.0',
    'constraints'      => [
        'depends' => [
            'backend' => '12.4.99-13.0.99',
            'dashboard' => '12.4.99-13.0.99',
            'fluid' => '12.4.99-13.0.99',
            'frontend' => '12.4.99-13.0.99',
            'typo3' => '12.4.99-13.0.99',
        ],
    ],
];
