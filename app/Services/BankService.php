<?php


namespace App\Services;


class BankService
{
    protected $URL;
    protected $secretKey;
    protected $timeOut;

    public function __construct($config = null)
    {
        $this->URL = isset ($config['URL'])
            ? $config['URL']
            : config('casino.bankService.URL');

        $this->secretKey = isset ($config['SecretKey'])
            ? $config['SecretKey']
            : config('casino.bankService.SecretKey');

        $this->timeOut = isset ($config['TimeOut'])
            ? $config['TimeOut']
            : config('casino.bankService.TimeOut');
    }

    /**
     * @param $data - eny data for money crediting
     * @return bool
     */
    public function sendOrderToBank($data)
    {
        $request = [
            'SecretKey' => $this->secretKey,
            'data' => $data
        ];
        // TODO make curl request to URL
        sleep(1);

        // Generate fake results, 30% - errors, 70% - successful
        if (mt_rand(1,10)>3)
            return true; // successful
        else
            throw new \LogicException('Error connect to bank (for example)'); // error
    }
}
