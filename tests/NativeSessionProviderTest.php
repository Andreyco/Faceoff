<?php

if (!session_id()) {
    session_start();
}

class SessionDataProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
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
        $this->assertSame($this->provider->get('just-a-random-key'), null);

        $this->provider->put('key', 'value');
        $this->assertSame($this->provider->get('key'), 'value');

        $this->assertSame($this->provider->get('another-key', 1000), 1000);
    }

    public function testForgetMethod()
    {
        $this->provider->put('key', 'value');
        $this->provider->forget('key');
        $this->assertSame($this->provider->get('key', false), false);
    }

}