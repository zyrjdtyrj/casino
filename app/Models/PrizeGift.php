<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrizeGift extends Prize
{
    use HasFactory;

    public static $type = 'Gift';

    /**
     * @return int
     */
    public function getGift()
    {
        return CasinoGift::find($this->prize['gift']);
    }

    public function getPrizeName()
    {
        return static::$type . ': ' . $this->prize['name'];
    }


}
