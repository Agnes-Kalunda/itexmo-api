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
}





?>