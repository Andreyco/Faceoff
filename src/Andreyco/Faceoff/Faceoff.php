<?php namespace Andreyco\Faceoff;

use Andreyco\Faceoff\SessionProviders\SessionProviderInterface;

class Faceoff extends \Facebook
{

    /**
     * Configuration settings.
     * @var array
     */
    protected $config;

    /**
     * Session storage object.
     */
    protected $sessionProvider;

    /**
     * Initialize Facebook instance and set data provider.
     * @var array
     * @var Andreyco\Faceoff\SessionProvider\SessionProviderInterface
     */
    public function __construct(array $config, SessionProviderInterface $sessionProvider)
    {
        $this->config = $config;

        $this->sessionProvider = $sessionProvider;

        parent::__construct($config['init']);
    }

    /**
     * Store value for defined key.
     * @var string
     * @var mixed
     */
    protected function setPersistentData($key, $value)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to getPersistentData.');
            return $default;
        }

        $session_var_name = $this->constructSessionVariableName($key);

        $this->sessionProvider->put($session_var_name, $value);
    }

    /**
     * Find value by key or return default value if not found.
     * @var string
     * @var mixed
     * @return mixed
     */
    protected function getPersistentData($key, $default = false)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to getPersistentData.');
            return $default;
        }

        $session_var_name = $this->constructSessionVariableName($key);

        return $this->sessionProvider->get($session_var_name);
    }

    /**
     * Discard record by key.
     * @var string
     */
    protected function clearPersistentData($key)
    {
        $this->sessionProvider->forget($key);
    }

    /**
     * Discard all records and shared session.
     */
    protected function clearAllPersistentData()
    {
        foreach (self::$kSupportedKeys as $key) {
            $this->clearPersistentData($key);
        }

        if ($this->sharedSessionID) {
            $this->deleteSharedSessionCookie();
        }
    }

    /**
     * Get data for current user
     *
     * @param array $params
     * @return array
     */
    public function me(array $params = array())
    {
        $fields = isset($params['fields']) && is_array($params['fields'])
            ? implode(',', $params['fields'])
            : '';

        unset($params['fields']);

        return $this->api("/me?fields={$fields}", 'GET', $params);
    }

    /**
     * Check, whether user already likes visited Facebook page.
     * @return mixed Return NULL if cannot determine, or BOOL otherwise.
     */
    public function likesPage()
    {
        $signedRequest = $this->getSignedRequest();

        if (is_null($signedRequest) || ! array_key_exists('page', $signedRequest)) {
            return null;
        }

        return $signedRequest['page']['liked'];
    }

    /**
     * Check, whether user is page administrator.
     * @return mixed Return NULL if cannot determine, or BOOL otherwise.
     */
    public function administratesPage()
    {
        $signedRequest = $this->getSignedRequest();

        if (is_null($signedRequest) || ! array_key_exists('page', $signedRequest)) {
            return null;
        }

        return $signedRequest['page']['admin'];
    }

}