<?php namespace Andreyco\Faceoff;

use Andreyco\Faceoff\DataProviders\DataProviderInterface;

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
    protected $dataProvider;

    /**
     * Initialize Facebook instance and set data provider.
     * @var array
     * @var Andreyco\Faceoff\DataProviders\DataProviderInterface
     */
    public function __construct(array $config, DataProviderInterface $dataProvider)
    {
        $this->config = $config;

        $this->dataProvider = $dataProvider;

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

        $this->dataProvider->put($session_var_name, $value);
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

        return $this->dataProvider->get($session_var_name);
    }

    /**
     * Discard record by key.
     * @var string
     */
    protected function clearPersistentData($key)
    {
        $this->dataProvider->forget($key);
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

}