<?php

class SessionDataProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
        $_SESSION = array();

        $this->provider = new Andreyco\Faceoff\DataProviders\NativeSessionProvider;
    }

    public function testPutMethod()
    {
        $keys = array('key', 'key2', 'key3');

        $this->assertEmpty($_SESSION);

        foreach($keys as $key) {
            $this->provider->put($key, $key);
        }

        $this->assertCount(count($keys), $_SESSION);
    }

    public function testGetMethod()
    {
        $this->provider->put('key', 'value');
        $this->assertEquals($this->provider->get('key'), 'value');

        $this->assertEquals($this->provider->get('another-key', 1000), 1000);
    }

    public function testForgetMethod()
    {
        $this->provider->put('key', 'value');
        $this->provider->forget('key');
        $this->assertEquals($this->provider->get('key', false), false);
    }

}