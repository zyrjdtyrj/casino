<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrizeMoney extends Prize
{
    use HasFactory;

    public static $type = 'Money';

    protected static $states = ['wait', 'canceled', 'received', 'converted'];

    /**
     * @return int
     */
    public function getAmount()
    {
        return (int)$this->prize['amount'];
    }

    public function getPrizeName()
    {
        $name = static::$type . ': ' . $this->prize['amount'] . '$';

        if ($this->state == 'converted')
            $name .= ' converted to bonus: ' . $this->prize['bonus'];

        return $name;
    }

    public function setBonusAmount($amount)
    {
        $prizeData = $this->prize;
        $prizeData['bonus'] = $amount;
        $this->prize = $prizeData;
    }

}
