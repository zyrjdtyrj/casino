<?php

namespace App\Models;

use App\Services\Prize\PrizeBonusService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrizeBonus extends Prize
{
    use HasFactory;

    public static $type = 'Bonus';

    /**
     * @return int
     */
    public function getAmount()
    {
        return (int)$this->prize['amount'];
    }

    public function getPrizeName()
    {
        return static::$type . ': ' . $this->prize['amount'];
    }


}
