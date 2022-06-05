<?php
namespace App\Services\Api\V1;

use App\Models\Api\V1\Wallet;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Models\Api\V1\Transaction;

class TransactionService extends Service{
    
    private function guzzle_http_request($project_api_url){
        try{
            $client = new GuzzleHttpClient();
            $res = $client->request('GET',$project_api_url);
            $body = json_decode($res->getBody()); 
            return $body;
        }
        catch (ClientException $e) {
            return "Error";
        }
    }

    private function create($request,$credit,$n=[]){
        $image = ($request->image) ? File::createFromBase64($request->image) : null;
        return Transaction::create([
            'wallet_id' => (count($n)) ? $n['wallet_id'] : $request->wallet_id,
            'category_id' => $request->category_id,
            'payment_method_id' => $request->payment_method_id,
            'date' => $request->date,
            'debit' => $request->debit,
            'credit' => $credit,
            'image' => $image,
            'note' => $request->note
        ]);
    }

    private function transaction_inner($wallets,$request){
        $numbers = [];
        $total_number = 0;
        foreach($wallets as $wallet){
            if($wallet->project_api_url){
                $project_api_url = $wallet->project_api_url;
                $number = $this->guzzle_http_request($project_api_url);
                $numbers[] = [
                    'wallet_id' => $wallet->id,
                    'number' => $number
                ];
                $total_number += $number;
            }
            else{
                $credit = round($request->credit/count($wallets),2);
                $transaction = $this->create($request,$credit);            
            }
        }
        foreach($numbers as $n){
            $credit = round($request->credit/$total_number * $n['number'],2);
            $transaction = $this->create($request,$credit,$n);            
        }
        return $transaction;
    }

    public function run($request){
        if($request->filled('credit')){
            if($request->type == TransactionRequest::TYPE_FIRM){
                $wallets = Wallet::where('firm_id',$request->firm_id)->get();
                $transaction = $this->transaction_inner($wallets,$request);
            }
            elseif($request->type == TransactionRequest::TYPE_WALLET){
                $w = Wallet::findOrFail($request->wallet_id);
                if($w->children()->count()){
                    $wallets = $w->children;
                    $transaction = $this->transaction_inner($wallets,$request);
                }
                else{
                    $credit = $request->credit;
                    $transaction = $this->create($request,$credit);
                }
            }
        }
        elseif($request->filled('debit')){
            $credit = $request->credit;
            $transaction = $this->create($request,$credit);
        }

        return $transaction;
    }

}