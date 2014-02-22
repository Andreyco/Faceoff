<?php namespace Andreyco\Faceoff;

use Andreyco\Faceoff\SessionProviders\SessionProviderInterface;

class Faceoff extends \Facebook
{
    use \Andreyco\Faceoff\Traits\Session;

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
     * Get data for current user.
     *
     * @param array $fields
     * @return array
     */
    public function me($fields = array())
    {
        $fields = is_array($fields) ? implode(',', $fields) : $fields;

        return $this->api("/me?fields={$fields}", 'GET');
    }

    /**
     * Get friend list of current user.
     *
     * @param array $params
     * @return array
     */
    public function friends()
    {
        return $this->api("/me/friends", 'GET');
    }

    /**
     * Execute FQL query with support for multiqueries.
     *
     * @param mixed $query Single query or array of queries to execute.
     * @return array
     */
    public function fql($query)
    {
        $method = is_array($query) && count($query > 1)
            ? 'fql.multiquery'
            : 'fql.query';

        $queryAttr = $method === 'fql.query' ? 'query' : 'queries';

        return $this->api(array(
            'method'    => $method,
            $queryAttr  => $query
        ));
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