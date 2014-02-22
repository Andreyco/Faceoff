<?php

if (!session_id()) {
    session_start();
}

class FaceoffTest extends PHPUnit_Framework_TestCase
{
    protected $faceoff;

    protected $token = '';

    public function setUp()
    {
        $provider = new Andreyco\Faceoff\SessionProviders\NativeSessionProvider;
        $config = array(
            'init' => array('appId' => null, 'secret' => null)
        );

        $this->faceoff = new Andreyco\Faceoff\Faceoff($config, $provider);
    }

    public function testMeMethod()
    {
        $params = array(
            'fields' => array(),
            'access_token' => $this->token
        );

        $this->assertSame(
            $this->faceoff->api('/me', 'GET', $params),
            $this->faceoff->me($params)
        );

        // Filter fields
        $params['fields'] = array('first_name');
        $data1 = $this->faceoff->me($params);

        $params['fields'] = 'first_name';
        $data2 = $this->faceoff->me($params);

        // Test presence of keys
        $this->assertArrayHasKey('first_name', $data1);
        $this->assertArrayNotHasKey('last_name', $data1);

        // By comparing result sets, we do not need to test second result set!
        $this->assertSame($data1, $data2);
    }
}