<?php

return [
    'classes' => [
        'prizeFactory' => \App\Services\PrizeFactory::class,
        'prizeModel' => \App\Models\Prize::class,
        'gamblerModel' => \App\Models\Gambler::class,
        'giftModel' => \App\Models\CasinoGift::class,
        'moneyModel' => \App\Models\CasinoMoney::class,
        'bankService' => \App\Services\BankService::class
    ],
    'prizeServices' => [
        \App\Services\Prize\PrizeMoneyService::class => [
            'generatePrize' => [
                'amountMin' => 1,
                'amountMax' => 10
            ],
            'bankService' => [
                'URL' => 'https://api.bank.site',
                'SecretKey' => 'sd1kh1k2j3k12',
                'TimeOut' => 10
            ],
            'rateConvertToBonus' => 2
        ],
        \App\Services\Prize\PrizeBonusService::class => [
            'generatePrize' => [
                'amountMin' => 2,
                'amountMax' => 20
            ],
        ],
        \App\Services\Prize\PrizeGiftService::class => [

        ]
    ]
];
