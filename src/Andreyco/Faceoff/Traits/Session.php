<?php namespace Andreyco\Faceoff\Traits;

trait Session
{
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
}