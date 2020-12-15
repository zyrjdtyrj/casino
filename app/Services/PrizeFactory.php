<?php


namespace App\Services;


use App\Models\Gambler;
use App\Models\Prize;
use Illuminate\Support\Facades\App;

class PrizeFactory
{
    /**
     * @var array
     */
    protected $prizeTypesMap;

    public function __construct($typeMap = null)
    {
        $this->prizeTypesMap = $typeMap ? $typeMap : Prize::$types;
    }

    /**
     * @param $prizeType
     * @param $prize
     * @param null|Gambler $gambler
     */
    public function create($prizeType, $prizeData, $gambler=null)
    {
        if (!array_key_exists($prizeType, $this->prizeTypesMap)) {
            throw new \InvalidArgumentException('Invalid prize type');
        }

        if (!$gambler) {
            $gambler = App::make('CasinoService')->getGambler();
        }

        $prize = new $this->prizeTypesMap[$prizeType] ([
            'gambler_id' => $gambler->id,
            'type' => $prizeType,
            'prize' => $prizeData,
            'state' => 'wait'
        ]);
        $prize->save();

        return $prize;
    }

}
