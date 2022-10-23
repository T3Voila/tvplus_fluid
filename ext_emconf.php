<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Fluid for TV+',
    'description' => 'Fluid renderer for TemplaVoilà! Plus',
    'author' => 'Alexander Opitz',
    'author_email' => 'alexander.opitz@davitec.de',
    'author_company' => 'Davitec GmbH',
    'version' => '0.3.0',
    'state' => 'beta',
    'clearcacheonload' => 1,
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-11.5.99',
            'fluid' => '8.7.0-11.5.99',
            'templavoilaplus' => '8.1.1-8.2.99',
        ],
    ],
];
