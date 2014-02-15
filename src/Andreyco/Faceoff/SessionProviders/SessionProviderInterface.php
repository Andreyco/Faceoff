<?php namespace Andreyco\Faceoff\SessionProviders;

interface SessionProviderInterface
{
    /**
     * Find value by key or return default value if not found.
     * @var string
     * @var mixed
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Store value for defined key.
     * @var string
     * @var mixed
     */
    public function put($key, $value);

    /**
     * Discard record by key.
     * @var string
     */
    public function forget($key);
}