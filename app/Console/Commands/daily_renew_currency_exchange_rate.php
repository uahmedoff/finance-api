<?php

namespace App\Console\Commands;

use App\Models\Api\V1\Currency;
use App\Models\Api\V1\ExchangeRate;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;

class daily_renew_currency_exchange_rate extends Command{

    protected $signature = 'daily:renew_currency_exchange_rate';

    protected $description = 'Daily renew currency exchange rate via CBU';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        try{
            $client = new GuzzleHttpClient();
            $res = $client->request('GET',"https://cbu.uz/ru/arkhiv-kursov-valyut/json");
            $cbu_rate = json_decode($res->getBody()); 
            $currencies = Currency::all();
            foreach($currencies as $currency){
                foreach($cbu_rate as $cbur){
                    if($currency->ccy == $cbur->Ccy){
                        $exchange_rate = ExchangeRate::create([
                            'currency_id' => $currency->id,
                            'date' => date("Y-m-d"),
                            'rate' => $cbur->Rate
                        ]);
                        echo "Exchange rate inserted";
                    }
                }
            }
        }
        catch (ClientException $e) {
            return "Error";
        }
    }
}
