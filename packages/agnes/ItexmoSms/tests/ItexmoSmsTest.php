<?php

namespace Agnes\ItexmoSms\Tests;

use Agnes\ItexmoSms\ItexmoSms;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ItexmoSmsTest extends TestCase
{
    protected $itexmo;

    protected function setUp(): void
    {
        parent::setUp();

        $config = [
            'api_url' => 'https://api.itexmo.com/api',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'api_code' => 'TEST-API-CODE',
        ];

        $this->itexmo = new ItexmoSms($config);
    }

    public function testBroadcast()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'DateTime' => '2020-01-03 15:04:33',
                'Error' => false,
                'TotalSMS' => 1,
                'Accepted' => 1,
                'TotalCreditUsed' => 1,
                'Failed' => 0,
                'ReferenceId' => 'PRSAM75814724521785347215'
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->itexmo->setClient($client);

        $result = $this->itexmo->broadcast(['1234567890'], 'Test message from Agnes');

        $this->assertTrue($result['success']);
        $this->assertEquals(1, $result['data']['TotalSMS']);
        $this->assertEquals('PRSAM75814724521785347215', $result['data']['ReferenceId']);
    }

    public function testBroadcast2d()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'DateTime' => '2020-01-03 15:04:33',
                'Error' => false,
                'TotalSMS' => 2,
                'Accepted' => 2,
                'TotalCreditUsed' => 2,
                'Failed' => 0,
                'ReferenceId' => 'PRSAM75814724521785347216'
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->itexmo->client = $client;

        $messages = [
            ['recipient' => '1234567890', 'message' => 'Test message 1'],
            ['recipient' => '0987654321', 'message' => 'Test message 2'],
        ];

        $result = $this->itexmo->broadcast2d($messages);

        $this->assertTrue($result['success']);
        $this->assertEquals(2, $result['data']['TotalSMS']);
        $this->assertEquals('PRSAM75814724521785347216', $result['data']['ReferenceId']);
    }

    public function testBroadcastOtp()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'DateTime' => '2020-01-03 15:04:33',
                'Error' => false,
                'TotalSMS' => 1,
                'Accepted' => 1,
                'TotalCreditUsed' => 1,
                'Failed' => 0,
                'ReferenceId' => 'PRSAM75814724521785347217'
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->itexmo->client = $client;

        $result = $this->itexmo->broadcastOtp('1234567890', 'Your OTP is 123456');

        $this->assertTrue($result['success']);
        $this->assertEquals(1, $result['data']['TotalSMS']);
        $this->assertEquals('PRSAM75814724521785347217', $result['data']['ReferenceId']);
    }

}