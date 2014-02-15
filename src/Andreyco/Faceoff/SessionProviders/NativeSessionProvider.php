<?php namespace Andreyco\Faceoff\SessionProviders;

class NativeSessionProvider implements SessionProviderInterface
{

    /**
     * Initialize session if needed.
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Find value by key or return default value if not found.
     * @var string
     * @var mixed
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return isset($_SESSION[ $key ]) ? $_SESSION[ $key ] : $default;
    }

    /**
     * Store value for defined key.
     * @var string
     * @var mixed
     */
    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Discard record by key.
     * @var string
     */
    public function forget($key)
    {
        unset($_SESSION[$key]);
    }

}