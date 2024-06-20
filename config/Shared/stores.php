<?php

$stores = [];

if (getenv('SPRYKER_ACTIVE_STORES')) {
    $activeStores = array_map('trim', explode(',', getenv('SPRYKER_ACTIVE_STORES')));

    //condition implemented for testing the entire Spryker with the codecept run command
    if (in_array('DE', $activeStores) && in_array('AT', $activeStores)) {
        $activeStores[0] = 'AU';
        array_pop($activeStores);
    }

    $templates = [];
    $templates['default'] = [
        // different contexts
        'contexts' => [
            // shared settings for all contexts
            '*' => [
                'timezone' => 'Australia/Canberra',
                'dateFormat' => [
                    // short date (01.02.12)
                    'short' => 'd/m/Y',
                    // medium Date (01. Feb 2012)
                    'medium' => 'd. M Y',
                    // date formatted as described in RFC 2822
                    'rfc' => 'r',
                    'datetime' => 'Y-m-d H:i:s',
                ],
            ],
            // settings for contexts (overwrite shared)
            'yves' => [],
            'zed' => [
                'dateFormat' => [
                    // short date (2012-12-28)
                    'short' => 'Y-m-d',
                ],
            ],
        ],
        'locales' => [
            // first entry is default
            'en' => 'en_AU',
        ],
        // first entry is default
        'countries' => ['AU'],
        // internal and shop
        'currencyIsoCode' => 'AUD',
        'currencyIsoCodes' => ['AUD'],
        'queuePools' => [
            'synchronizationPool' => [],
        ],
        'storesWithSharedPersistence' => [],
    ];

    foreach ($activeStores as $store) {
        $stores[$store] = $templates[$store] ?? $templates['default'];
        $stores[$store]['storesWithSharedPersistence'] = array_diff($activeStores, [$store]);
        $stores[$store]['queuePools']['synchronizationPool'] = array_map(static function ($store) {
            return $store . '-connection';
        }, $activeStores);
    }

    return $stores;
}

$stores['AU'] = [
    // different contexts
    'contexts' => [
        // shared settings for all contexts
        '*' => [
            'timezone' => 'Australia/Canberra',
            'dateFormat' => [
                // short date (01.02.12)
                'short' => 'd/m/Y',
                // medium Date (01. Feb 2012)
                'medium' => 'd. M Y',
                // date formatted as described in RFC 2822
                'rfc' => 'r',
                'datetime' => 'Y-m-d H:i:s',
            ],
        ],
        // settings for contexts (overwrite shared)
        'yves' => [],
        'zed' => [
            'dateFormat' => [
                // short date (2012-12-28)
                'short' => 'Y-m-d',
            ],
        ],
    ],
    'locales' => [
        // first entry is default
        'en' => 'en_AU',
    ],

    // first entry is default
    'countries' => ['AU'],
    // internal and shop
    'currencyIsoCode' => 'AUD',
    'currencyIsoCodes' => ['AUD'],
    'queuePools' => [
        'synchronizationPool' => [
            'US-connection',
        ],
    ],
    'storesWithSharedPersistence' => [],
];

return $stores;
