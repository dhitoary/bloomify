<?php

return [
    // Zona pengiriman berdasarkan kota
    'zones' => [
        'Jakarta' => ['cost' => 15000, 'days' => '1-2'],
        'Tangerang' => ['cost' => 15000, 'days' => '1-2'],
        'Depok' => ['cost' => 18000, 'days' => '2-3'],
        'Bekasi' => ['cost' => 20000, 'days' => '2-3'],
        'Bogor' => ['cost' => 20000, 'days' => '2-3'],
        'Bandung' => ['cost' => 35000, 'days' => '3-4'],
        'Surabaya' => ['cost' => 50000, 'days' => '4-5'],
        'Yogyakarta' => ['cost' => 45000, 'days' => '3-4'],
        'Medan' => ['cost' => 60000, 'days' => '5-6'],
        'Makassar' => ['cost' => 75000, 'days' => '6-7'],
        'Bali' => ['cost' => 65000, 'days' => '5-6'],
    ],

    // Kurir pengiriman
    'couriers' => [
        'jne' => [
            'name' => 'JNE',
            'logo' => '📦 JNE',
            'services' => [
                'REG' => ['name' => 'Regular', 'multiplier' => 1.0],
                'OKE' => ['name' => 'Ongkir Kilat', 'multiplier' => 1.3],
                'YES' => ['name' => 'Yes Express', 'multiplier' => 1.5],
            ]
        ],
        'pos' => [
            'name' => 'Pos Indonesia',
            'logo' => '🏤 Pos Indonesia',
            'services' => [
                'REG' => ['name' => 'Reguler', 'multiplier' => 1.0],
                'EXPRESS' => ['name' => 'Express', 'multiplier' => 1.4],
            ]
        ],
        'tiki' => [
            'name' => 'TIKI',
            'logo' => '🚚 TIKI',
            'services' => [
                'REG' => ['name' => 'Regular', 'multiplier' => 1.0],
                'ECO' => ['name' => 'Ekonomis', 'multiplier' => 0.9],
                'OVERNIGHT' => ['name' => 'Overnight', 'multiplier' => 1.6],
            ]
        ],
        'grab' => [
            'name' => 'GrabExpress',
            'logo' => '🏍️ GrabExpress',
            'services' => [
                'SAME_DAY' => ['name' => 'Same Day', 'multiplier' => 2.0],
                'NEXT_DAY' => ['name' => 'Next Day', 'multiplier' => 1.5],
            ]
        ],
    ],

    // Default courier
    'default_courier' => 'jne',
    'default_service' => 'REG',
];
