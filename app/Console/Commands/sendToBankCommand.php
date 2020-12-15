<?php

namespace App\Console\Commands;

use App\Models\PrizeMoney;
use App\Services\Prize\PrizeMoneyService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class sendToBankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'casino:send2bank {NumberOrders? : Maximum number orders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command sends orders to the bank for crediting prizes';

    /**
     * @var string
     */
    protected $help = <<<TXT
The only command parameter specifies the maximum number of records to process
Default limit is
TXT;

    /** default limit process records
     * @var int
     */
    protected $limit = 10;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $limit = $arguments['NumberOrders'];

        if ($limit && !is_numeric($limit)) {
            $this->error('Required number');
            return 1;
        } elseif (!$limit) {
            $this->info($this->description . PHP_EOL . $this->help . ' ' . $this->limit);
            $limit = $this->limit;
        }


        if (!$this->confirm('Send to bank [' . $limit . '] orders?', true)) {
            return 0;
        }

        /**
         * @var $moneyService PrizeMoneyService
         */
        $moneyService = App::make('PrizeMoneyService');
        $moneyPrizes = $moneyService->getPrizesForCrediting($limit);

        $errors = [];
        $okCounter = 0;
        $this->withProgressBar($moneyPrizes, function ($prize) use (&$errors, &$okCounter) {
            /**
             * @var $prize PrizeMoney
             */
            try {
                $prize->state = 'received';
                $okCounter++;
            } catch (\Exception $exception) {
                $errors[] = $prize->id . '# [' . $prize->getPrizeName() . '] ' . $exception->getMessage();
            }
        });

        $resultsStr = PHP_EOL . 'Results: Ok-' . $okCounter;
        if (count($errors)) {
            $resultsStr .= ', Errors-' . count($errors);
            $resultsStr .= ', Total-' . ($okCounter + count($errors));
        }
        $resultsStr .= PHP_EOL;
        $this->info($resultsStr);

        if (count($errors)) {
            $errorsStr = 'Errors:' . PHP_EOL;
            foreach ($errors as $error) {
                $errorsStr .= $error . PHP_EOL;
            }
            $this->error($errorsStr);
        }

        return 0;
    }
}
