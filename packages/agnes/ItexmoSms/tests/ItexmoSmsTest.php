<?php

namespace Agnes\ItexmoSms\Tests;

use Agnes\ItexmoSms\ItexmoSms;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ItexmoSmsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Agnes\ItexmoSms\ItexmoSmsServiceProvider'];
    }

    public function testSuccessfulSms()
    {
        $mock = new MockHandler([
            new Response(200, [], '0'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $itexmoSms = $this->app->make(ItexmoSms::class);
        $itexmoSms->client = $client;

        $result = $itexmoSms->sendSms('1234567890', 'Test message');

        $this->assertTrue($result['success']);
        $this->assertEquals('Message sent successfully', $result['message']);
    }

    public function testFailedSms()
    {
        $mock = new MockHandler([
            new Response(200, [], '1'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $itexmoSms = $this->app->make(ItexmoSms::class);
        $itexmoSms->client = $client;

        $result = $itexmoSms->sendSms('1234567890', 'Test message');

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid number', $result['message']);
    }
}