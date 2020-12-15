<?php


namespace App\Services;


use App\Models\CasinoGift;
use App\Models\Gambler;
use App\Models\Prize;
use App\Models\User;
use App\Services\Prize\AbstractPrizeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Casino
{
    /**
     * @var PrizeFactory
     */
    protected $prizeFactory;

    /**
     * @var AbstractPrizeService[]
     */
    protected $prizeServices;

    /**
     * @var string
     */
    protected $gamblerModelClass;

    /**
     * @var string
     */
    protected $giftModelClass;

    /**
     * @var string
     */
    protected $moneyModelClass;


    public function __construct(
        $prizeFactoryClass = null,
        $prizeServiceClasses = null,
        $gamblerModelClass = null,
        $giftModelClass = null,
        $moneyModelClass = null,
        $bankServiceClass = null
    ) {
        $prizeFactoryClass = $prizeFactoryClass ? $prizeFactoryClass : config('casino.classes.prizeFactory');
        $this->prizeFactory = $prizeFactory = new $prizeFactoryClass();
        $this->gamblerModelClass = $gamblerModelClass ? $gamblerModelClass : config('casino.classes.gamblerModel');
        $this->giftModelClass = $giftModelClass ? $giftModelClass : config('casino.classes.giftModel');
        $this->moneyModelClass = $moneyModelClass ? $moneyModelClass : config('casino.classes.moneyModel');

        if (!$bankServiceClass)
            $bankServiceClass = config ('casino.classes.bankService');

        App::bind('CasinoBankService', $bankServiceClass);

        $prizeServiceClasses = isset($prizeServiceClasses)
            ? new Collection($prizeServiceClasses)
            : new Collection(array_keys(config('casino.prizeServices')));

        $this->prizeServices = $prizeServiceClasses->map(function($serviceName) use ($prizeFactory) {
            return new $serviceName($prizeFactory);
        });

        // Create singletons to call services by name in the application
        $this->prizeServices->each(function($service) {
            App::singleton(class_basename($service), function() use ($service){
               return $service;
            });
        });
    }

    /**
     * @param Gambler $gambler
     * @return Prize
     * @throws \Exception
     */
    public function generatePrize ($gambler = null)
    {
        $allowedPrizeServices = $this->prizeServices->filter(function($prizeService){
            return $prizeService->allowedPrizeGenerate();
        });

        if (!count($allowedPrizeServices)) {
            throw new \Exception('Not allowed prize services');
        }

        /**
         * @var $randomService AbstractPrizeService
         */
        $randomService = $allowedPrizeServices->random(1)->first();
        $prize = $randomService->generatePrize($gambler);

        return $prize;
    }

    public function giftGetAvailable()
    {
        $giftModelClass = $this->giftModelClass;
        return $giftModelClass::where('amount', '>', '0')->get();
    }

    public function giftSetUsed(CasinoGift $casinoGift)
    {
        if ($casinoGift->amount < 1)
            throw new \LogicException('Gift is no longer available');

        $casinoGift->amount = $casinoGift->amount -1;
        $casinoGift->save();
    }

    public function giftSetUnused(CasinoGift $casinoGift)
    {
        $casinoGift->amount = $casinoGift->amount +1;
        $casinoGift->save();
    }

    /**
     * @return int
     */
    public function moneyGetAvailable()
    {
        return $this->moneyModelClass::find(1)->bank;
    }

    public function moneyReserved($amount)
    {
        $bank = $this->moneyModelClass::find(1);
        if ($bank->bank < $amount) {
            throw new \LogicException('Casino bank haven\'t such money');
        }

        $bank->bank = $bank->bank - $amount;
        $bank->save();
    }

    public function moneyUnreserved($amount)
    {
        $bank = $this->moneyModelClass::find(1);
        $bank->bank = $bank->bank + $amount;
        $bank->save();
    }
    /**
     * @param $gambler Gambler
     * @param $amount int
     */
    public function bonusGamblerPlus(Gambler $gambler, $amount)
    {
        $gambler->bonus = $gambler->bonus + $amount;
        $gambler->save();
    }

    /**
     * @param $gambler Gambler
     * @param $amount int
     */
    public function bonusGamblerMinus (Gambler $gambler, $amount)
    {
        if($gambler->bonus < $amount)
            throw new \LogicException('Not enough bonuses');

        $gambler->bonus = $gambler->bonus - $amount;
        $gambler->save();
    }

    /**
     * @return User
     */
    public function getGambler()
    {
        $gambler = Auth::user();

        return $gambler;
    }
}
