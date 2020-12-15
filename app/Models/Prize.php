<?php

namespace App\Models;

use App\Services\Prize\AbstractPrizeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Prize extends Model
{
    use HasFactory;

    public static $types = [
        'Gift'  => PrizeGift::class,
        'Bonus' => PrizeBonus::class,
        'Money' => PrizeMoney::class
    ];

    /** Possible states of an entity
     * @var string[]
     */
    protected static $states = ['wait', 'canceled', 'received'];

    public static $type;

    public $table = 'prizes';

    protected $casts = [
        'prize' => 'array'
    ];

    public $fillable = ['gambler_id', 'prize', 'state', 'type'];

    /** Return name for interface
     * @return string
     */
    public function getPrizeName(){}

    public function gambler()
    {
        return $this->hasOne(Gambler::class, 'id', 'gambler_id');
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            if ($query->getModel()::$type) {
                $query->where('type', $query->getModel()::$type);
            }
        });
    }

    /**
     * @return Gambler
     */
    public function getGambler()
    {
        return Gambler::find($this->gambler_id);
    }

    /** Overloading for generating collections of inherited classes
     *
     * @param array $attributes
     * @param null $connection
     * @return Prize
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        if (!static::$type) {
            $model = new static::$types[$attributes->type]([]);
            return $model->newFromBuilder($attributes, $connection);
        }
        return parent::newFromBuilder($attributes, $connection);
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return Prize|mixed
     * @throws \LogicException
     */
    public function setAttribute($key, $val)
    {
        if ($key == 'state') {

            if (!in_array($val, static::$states)) {
                throw new \InvalidArgumentException('State [' . $val . '] is not correct for this Prize');
            }

            if ($this->state != 'wait' && in_array($val,['received', 'cancel', 'converted'])) {
                throw new \LogicException('For change state the prize must be in the state \'wait\'');
            }

            $prizeService = $this->getService();
            $prizeServiceEventMethod = 'eventPrizeState'.Str::ucfirst($val);
            if (method_exists($prizeService, $prizeServiceEventMethod)) {
                $prizeService->$prizeServiceEventMethod($this);
            }
        }
        return parent::setAttribute($key, $val);

    }

    /**
     * @return AbstractPrizeService
     */
    public function getService()
    {
        /**
         * @var $service AbstractPrizeService;
         */
        $service = App::make('Prize'.static::$type.'Service');
        return $service;
    }

    /**
     * @param Gambler $gambler
     * @return Prize
     */
    public static function getPrizesOfGambler(Gambler $gambler)
    {
        return self::where('gambler_id', $gambler->id)->get();
    }

}
