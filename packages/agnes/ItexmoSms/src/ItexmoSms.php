<?php 

namespace Agnes\ItexmoSms;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class ItexmoSms{
    protected $client;
    protected $config;

    public function __construct(array $config){
        $this->config = $config;
        $this->client = new Client();

    }

    public function broadcast($recipients, $message){

        return $this->makeRequest('broadcast',[
            'email' => $this->config['email'],
            'password' => $this->config['password'],
            'APICode'=>$this->config['api_code'],
            'Recipients'=> json_encode($recipients),
            'Message'=> $message,
        ]);

    }

    public function broadcast2d(array $messages){
        return $this->makeRequest('broadcast-2d',[
            'email'=> $this->config['email'],
            'password'=> $this->config['password'],
            'ApiCode'=> $this->config['api_code'],
            'Messages'=> json_encode($messages),
        ]);
    }


    
}



?>