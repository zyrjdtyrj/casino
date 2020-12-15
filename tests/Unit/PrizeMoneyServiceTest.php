<?php

namespace Tests\Unit;

use App\Services\PrizeFactory;
use PHPUnit\Framework\TestCase;
use App\Services\Prize\PrizeMoneyService;
use Mockery as M;

class PrizeMoneyServiceTest extends TestCase
{
    /**
     * @dataProvider dataForConvertMoneyToBonus
     */
    public function testConvertMoneyToBonus($rate, $moneyAmount, $bonusAmount)
    {
        $prizeFactory = M::mock(PrizeFactory::class);

        $config = [
            'generatePrize' => [
                'amountMin' => 1,
                'amountMax' => 10,
            ],
            'rateConvertToBonus' => $rate
        ];

        $prizeMoneyService = new PrizeMoneyService($prizeFactory, $config);
        $this->assertEquals($bonusAmount, $prizeMoneyService->convertMoneyToBonus($moneyAmount));
    }

    public function dataForConvertMoneyToBonus()
    {
        // rate, money, bonus
        return [
            [1, 1, 1],
            [2, 1, 2],
            [1.5, 10, 15],
            [1.3, 3, 4]
        ];
    }
}
