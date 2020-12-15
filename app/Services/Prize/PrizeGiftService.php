<?php


namespace App\Services\Prize;


use App\Models\Gambler;
use App\Models\Prize;
use App\Models\PrizeGift;
use App\Services;
use Illuminate\Database\Eloquent\Collection;

class PrizeGiftService extends AbstractPrizeService
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
    public function __construct(Services\PrizeFactory $prizeFactory)
    {
        parent::__construct($prizeFactory);
    }

    /**
     * @return Collection
     */
    protected function getAvailableGifts()
    {
        return $this->getCasinoService()->giftGetAvailable();
    }

    /**
     * @return bool
     */
    public function allowedPrizeGenerate()
    {
        if ($this->getAvailableGifts()->count() > 0)
            return true;

        return false;
    }

    /**
     * @param Gambler $gambler
     * @return PrizeGift
     */
    public function generatePrize($gambler = null)
    {

        $availableGifts = $this->getAvailableGifts();
        $giftRandom = $availableGifts->shuffle()->first();

        $prize = $this->prizeFactory->create(
            'Gift',
            ['gift' => $giftRandom->id, 'name' => $giftRandom->name],
            $gambler
        );
        return $prize;
    }

    public function eventPrizeStateWait(Prize $prize)
    {
        $this->getCasinoService()->giftSetUsed($prize->getGift());
    }

    public function eventPrizeStateCanceled(Prize $prize)
    {
        $this->getCasinoService()->giftSetUnused($prize->getGift());
    }

}
