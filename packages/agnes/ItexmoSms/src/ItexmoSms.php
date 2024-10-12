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

    protected function handleResponse($result){
        switch($result){
            case 0:
                return ['success' => true, 'message' => 'Message sent successfully'];
            case 1:
                return ['success' => false, 'message' => 'Invalid number'];
            case 2:
                return ['success' => false, 'message' => 'Invalid message'];
            case 3:
                return ['success' => false, 'message' => 'Invalid API key'];
            case 4:
                return ['success' => false, 'message' => 'Maximum message per day exceeded'];
            case 5:
                return ['success' => false, 'message' => 'Maximum allowed characters exceeded'];
            default:
                return ['success' => false, 'message' => 'Unknown error'];
        }
    }
}



?>