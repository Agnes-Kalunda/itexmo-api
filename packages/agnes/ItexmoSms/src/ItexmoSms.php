<?php 

namespace Agnes\ItexmoSms;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class ItexmoSms{
    protected $client;
    protected $apicode;

    public function __construct(){
        $this->client =new Client(['base_uri' =>'']);
        $this->apicode= Config::get('itexmo.api_code');
    }

    public function sendSMS($number, $message){
        $response = $this->client->post('',[
            'form_params'=>[
                '1'=> $number,
                '2'=> $message,
                '3'=>$this->apicode,
            ],
        ]);

        $result =$response->getBody()->getContents();

        return $this->handleResponse($result);

    }
}





?>