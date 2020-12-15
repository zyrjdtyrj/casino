<?php


namespace App\Services\Prize;


use App\Models\Gambler;
use App\Models\PrizeBonus;
use App\Services;

class PrizeBonusService extends AbstractPrizeService
{
    /**
     * @var Services\PrizeFactory
     */
    protected $prizeFactory;

    /**
     * @var int
     */
    protected $amountPrizeMin;

    /**
     * @var int
     */
    protected $amountPrizeMax;

    /**
     * PrizeMoneyService constructor.
     * @param Services\PrizeFactory $prizeFactory
     * @param null|array $config
     */
    public function __construct(Services\PrizeFactory $prizeFactory, $config = null)
    {
        parent::__construct($prizeFactory);

        $this->amountPrizeMin = isset($config['generatePrize']['amountMin'])
            ? $config['generatePrize']['amountMin']
            : config('casino.prizeServices.'.static::class.'.generatePrize.amountMin');

        $this->amountPrizeMax = isset($config['generatePrize']['amountMax'])
            ? $config['generatePrize']['amountMax']
            : config ('casino.prizeServices.'.static::class.'.generatePrize.amountMax');
    }

    public function allowedPrizeGenerate()
    {
        return true;
    }

    /**
     * @param Gambler $gambler
     * @return PrizeBonus
     */
    public function generatePrize($gambler = null)
    {
        $amountBonus = mt_rand($this->amountPrizeMin, $this->amountPrizeMax);
        $prize = $this->prizeFactory->create('Bonus', ['amount' => $amountBonus], $gambler);
        $prize->state = 'received';
        $prize->save();
        return $prize;
    }

    public function eventPrizeStateReceived(PrizeBonus $prize)
    {
        $this->getCasinoService()->bonusGamblerPlus($prize->getGambler(), $prize->getAmount());
    }

    public function eventPrizeStateCanceled(PrizeBonus $prize)
    {
        $this->getCasinoService()->bonusGamblerMinus($prize->getGambler(), $prize->getAmount());
    }



}
