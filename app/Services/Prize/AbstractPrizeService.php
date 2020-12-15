<?php


namespace App\Services\Prize;


use App\Models\Gambler;
use App\Models\Prize;
use App\Services\Casino;
use App\Services\PrizeFactory;
use Illuminate\Support\Facades\App;

abstract class AbstractPrizeService
{
    /**
     * @var PrizeFactory
     */
    protected $prizeFactory;

    /**
     * PrizeService constructor.
     * @param PrizeFactory $prizeFactory
     */
    public function __construct(PrizeFactory $prizeFactory)
    {
        $this->prizeFactory = $prizeFactory;
    }

    /**
     * @return bool
     */
    abstract public function allowedPrizeGenerate();

    /**
     * @param Gambler $gambler
     * @return Prize
     */
    abstract public function generatePrize($gambler = null);

    /**
     * @return Casino
     */
    protected function getCasinoService()
    {
        return App::make('CasinoService');
    }

}
