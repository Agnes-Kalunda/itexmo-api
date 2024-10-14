<?php

namespace Agnes\ItexmoSms\Tests\Integration;

use Agnes\ItexmoSms\ItexmoSms;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;

class ItexmoSmsIntegrationTest extends TestCase
{
    protected $itexmo;

    protected function setUp(): void
    {
        parent::setUp();

        $config = [
            'api_url' => 'https://api.itexmo.com/api',
            'email' => env('ITEXMO_EMAIL'), 
            'password' => env('ITEXMO_PASSWORD'),
            'api_code' => env('ITEXMO_API_CODE'),
        ];

        $this->itexmo = new ItexmoSms($config);
    }

    public function testIntegrationBroadcast()
    {
        $result = $this->itexmo->broadcast(['1234567890'], 'Test message from integration test');

        $this->assertTrue($result['success'], 'SMS sending failed: ' . $result['message']);

    }

    public function testIntegrationBroadcast2d()
    {
        $messages = [
            ['recipient' => '1234567890', 'message' => 'Integration Test message 1'],
            ['recipient' => '0987654321', 'message' => 'Integration Test message 2'],
        ];

        $result = $this->itexmo->broadcast2d($messages);

        $this->assertTrue($result['success'], 'SMS sending failed: ' . $result['message']);
    }

    public function testIntegrationBroadcastOtp()
    {
        $result = $this->itexmo->broadcastOtp('1234567890', 'Your OTP is 123456');

        $this->assertTrue($result['success'], 'OTP sending failed: ' . $result['message']);
    }

    public function testIntegrationQuery()
    {
        $result = $this->itexmo->query('BALANCE');

        $this->assertTrue($result['success'], 'Query failed: ' . $result['message']);
        $this->assertArrayHasKey('Balance', $result['data'], 'Balance key is missing in response');
    }
}
