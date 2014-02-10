<?php namespace Andreyco\Faceoff\DataProviders;

use Illuminate\Session\SessionManager;

class LaravelSessionProvider implements DataProviderInterface
{

    /**
     * Session manager.
     */
    protected $session;

    /**
     * Initialize session if needed.
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * Find value by key or return default value if not found.
     * @var string
     * @var mixed
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->session->get($key, $default);
    }

    /**
     * Store value for defined key.
     * @var string
     * @var mixed
     */
    public function put($key, $value)
    {
        $this->session->put($key, $value);
    }

    /**
     * Discard record by key.
     * @var string
     */
    public function forget($key)
    {
        $this->session->forget($key);
    }

}