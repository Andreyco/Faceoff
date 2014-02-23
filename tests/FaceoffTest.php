<?php

if (!session_id()) {
    session_start();
}

class FaceoffTest extends PHPUnit_Framework_TestCase
{
    protected $faceoff;

    public function setUp()
    {
        $provider = new Andreyco\Faceoff\SessionProviders\NativeSessionProvider;
        $config = array(
            'init' => array('appId' => null, 'secret' => null)
        );

        $this->faceoff = new Andreyco\Faceoff\Faceoff($config, $provider);

        // set valid token for testing here
        $this->faceoff->setAccessToken('');
    }

    public function testMeMethod()
    {
        $fields = array('first_name', 'last_name');

        $this->assertSame(
            $this->faceoff->api('/me?fields='.implode(',', $fields), 'GET'),
            $this->faceoff->me($fields)
        );

        // Filter fields
        $fields = array('first_name');
        $data1 = $this->faceoff->me($fields);

        $fields = 'first_name';
        $data2 = $this->faceoff->me($fields);

        // Test presence of keys
        $this->assertArrayHasKey('first_name', $data1);
        $this->assertArrayNotHasKey('last_name', $data1);

        // By comparing result sets, we do not need to test second result set!
        $this->assertSame($data1, $data2);
    }

    public function testFriendsMethod()
    {
        $this->assertSame(
            $this->faceoff->api('/me/friends', 'GET'),
            $this->faceoff->friends()
        );
    }

    public function testAlbumsMethod()
    {
        $this->assertSame(
            $this->faceoff->api('/me/albums'),
            $this->faceoff->albums()
        );
    }
}