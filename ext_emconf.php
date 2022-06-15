<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Fluid for TV+',
    'description' => 'Fluid renderer for TemplaVoilà! Plus',
    'author' => 'Alexander Opitz',
    'author_email' => 'opitz@extrameile-gehen.de',
    'author_company' => 'Extrameile GmbH',
    'version' => '0.1.0',
    'state' => 'alpha',
    'clearcacheonload' => 1,
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-11.5.99',
            'fluid' => '8.7.0-11.5.99',
            'templavoilaplus' => '8.0.3-',
        ],
    ],
];
