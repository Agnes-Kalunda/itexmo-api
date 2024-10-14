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


    public function broadcastOtp($recipient, $message){
        return $this->makeRequest('broadcast-otp',[
            'email'=> $this->config['email'],
            'password'=> $this->config['password'],
            'ApiCode'=> $this->config['api_code'],
            'Recipient'=> $recipient,
            'Message'=> $message,
        ]);
    }

    public function query($queryType, array $params = []){
        $data =[
            'email'=> $this->config['email'],
            'password'=> $this->config['password'],
            'ApiCode'=> $this->config['api_code'],
            'QueryType'=> $queryType,
        ];

        return $this->makeRequest('query', array_merge($data, $params));
    }


    protected function makeRequest($endpoint, array $params)
    {
        try {
            $response = $this->client->post($this->config['api_url'] . '/' . $endpoint, [
                'form_params' => $params,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $this->handleResponse($result, $endpoint);
        } catch (GuzzleException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    protected function handleResponse($result, $endpoint)
    {
        if (isset($result['Error']) && $result['Error'] === false) {
            return [
                'success' => true,
                'data' => $result,
            ];
        } else {
            return [
                'success' => false,
                'message' => $result['Message'] ?? 'Unknown error occurred',
                'data' => $result,
            ];
        }
    }
}





    




?>