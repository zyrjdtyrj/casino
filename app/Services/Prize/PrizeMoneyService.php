<?php


namespace App\Services\Prize;


use App\Models\Gambler;
use App\Models\Prize;
use App\Models\PrizeMoney;
use App\Services;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;

class PrizeMoneyService extends AbstractPrizeService
{

    /**
     * @var int
     */
    protected $amountPrizeMin;

    /**
     * @var int
     */
    protected $amountPrizeMax;


    /**
     * @var float
     */
    protected $rateConvertToBonus;

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
            : config('casino.prizeServices.' . static::class . '.generatePrize.amountMin');

        $this->amountPrizeMax = isset($config['generatePrize']['amountMax'])
            ? $config['generatePrize']['amountMax']
            : config('casino.prizeServices.' . static::class . '.generatePrize.amountMax');

        $this->rateConvertToBonus = isset($config['rateConvertToBonus'])
            ? $config['rateConvertToBonus']
            : config('casino.prizeServices.' . static::class . '.rateConvertToBonus');
    }

    public function allowedPrizeGenerate()
    {

        $casinoService = $this->getCasinoService();
        if ($casinoService->moneyGetAvailable() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param Gambler $gambler
     * @return PrizeMoney
     */
    public function generatePrize($gambler = null)
    {
        $moneyAvailable = $this->getCasinoService()->moneyGetAvailable();
        // Profitable solution for Gambler
        $amountBonus = mt_rand($this->amountPrizeMin, $this->amountPrizeMax);
        $amountBonus = min($amountBonus, $moneyAvailable);
//        // Profitable solution for Casino
//        $amountBonus = mt_rand($this->amountPrizeMin, min($moneyAvailable, $this->amountPrizeMax));

        $prize = $this->prizeFactory->create('Money', ['amount' => $amountBonus], $gambler);
        return $prize;
    }

    /**
     * @param int $limit
     * @return Collection
     */
    public function getPrizesForCrediting($limit = 10)
    {
        return PrizeMoney::where('state', 'wait')->orderBy('id')->limit($limit)->get();
    }

    /** Prize events on created
     * @param PrizeMoney $prize
     */
    public function eventPrizeStateWait(Prize $prize)
    {
        $this->getCasinoService()->moneyReserved($prize->getAmount());
    }

    /** Prize events before change state to Canceled
     * @param PrizeMoney $prize
     */
    public function eventPrizeStateCanceled(Prize $prize)
    {
        $this->getCasinoService()->moneyUnreserved($prize->getAmount());
    }

    /** Prize events before change state to Received
     * @param PrizeMoney $prize
     */
    public function eventPrizeStateReceived(Prize $prize)
    {
        /**
         * @var $bankService Services\BankService
         */
        $bankService = App::make('CasinoBankService');
        $bankService->sendOrderToBank([
            'recipient' => $prize->getGambler()->name,
            'amount' => $prize->getAmount()
        ]);
    }

    /** Prize events before change state to Converted
     * @param PrizeMoney $prize
     */
    public function eventPrizeStateConverted(PrizeMoney $prize)
    {
        $bonusPlus = $this->convertMoneyToBonus($prize->getAmount());

        $casinoService = $this->getCasinoService();
        $casinoService->bonusGamblerPlus($prize->getGambler(), $bonusPlus);
        $casinoService->moneyUnreserved($prize->getAmount());
        $prize->setBonusAmount($bonusPlus);
    }

    public function convertMoneyToBonus($amountMoney)
    {
        return round($this->rateConvertToBonus * $amountMoney, 0);
    }


}
