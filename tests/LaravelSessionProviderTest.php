<?php

class LaravelSessionProviderTest extends TestCase
{
    /**
     * Default preparation for each test
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->make('Andreyco\Faceoff\Support\Laravel\SessionProvider');
    }

    public function testPutMethod()
    {
        $this->provider->put('key', 'value');
        $this->assertEquals($this->provider->get('key'), 'value');
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