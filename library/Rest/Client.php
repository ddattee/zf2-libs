<?php
/**
 * REST client
 *
 * @category  Rest
 * @package   Rest
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Rest;

use Rest\Exception\InvalidMethodException;
use Rest\Exception\AuthenticationException;
use Rest\Exception\InvalidWsUrlException;
use Rest\Exception\ServiceErrorException;
use Rest\Exception\MissingParametersException;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\Cache\StorageFactory;
use Zend\Http\Client as HttpClient;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Client
 *
 * @package Rest
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Client extends HttpClient implements ServiceLocatorAwareInterface
{
    const GET    = 'GET';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    /**
     * @var string $service Contain the name of the service to call
     */
    protected $service;
    /**
     * @var bool $cache_enable Enable cache for the all REST API (activation must also be set per services)
     */
    protected $cache_enable;
    /**
     * @var array $cache_options Cache option for Filesystem adapter (refer to zf doc)
     */
    protected $cache_options = array();
    /**
     * @var Filesystem $cache Cache storage to access the cache
     */
    protected $cache;
    /**
     * @var bool Disable authentication for the ws
     */
    protected $disable_auth = false;

    /**
     * @var \Rest\Authentication\AdapterInterface $_auth_adaptor Rest authentication adaptor
     */
    private $_auth_adaptor;
    /**
     * @var null|string $_api_url Hostname of the API URL (must contain "http(s)://")
     */
    private $_api_url = null;
    /**
     * @var null|string $_access_token Api access token to use
     */
    private $_access_token = null;
    /**
     * @var null|array $_rest_config Rest config array
     */
    private $_rest_config = null;
    /**
     * @var array $servicesLocator ZF2 Services
     */
    private $servicesLocator;

    /**
     * Init the REST API Client
     * @param array $config Mandatory params : api_url. Optional params : http_config
     */
    public function __construct($config = array())
    {
        if (!empty($config)) {
            $this->init($config);
        }
    }

    /**
     * Load the config of the rest module
     *
     * @return array|mixed
     */
    public function getRestConfig()
    {
        if (!is_array($this->_rest_config)) {
            $this->_rest_config = $this->getServiceLocator()->get('config')['rest'];
        }
        return $this->_rest_config;
    }

    /**
     * Call GET method on a service with the given parameters
     *
     * @param null|array $params Array of key => value to replace in service URL
     *
     * @return mixed
     *
     * @throws InvalidMethodException
     */
    public function get($params = array())
    {
        $this->_loadService(Client::GET, $params);
        return $this->_callMethod(Client::GET);
    }

    /**
     * Call POST method on a service with the given parameters and sending the content as JSON
     *
     * @param array $content Array send as JSON in the request body
     * @param array $params Array of key => value to replace in service URL
     *
     * @return mixed
     *
     * @throws InvalidMethodException
     */
    public function post($content, $params = array())
    {
        $this->_loadService(Client::POST, $params);
        $this->getRequest()->setContent(json_encode($content));
        return $this->_callMethod(Client::POST);
    }

    /**
     * Call PUT method with given params
     *
     * @param null|array $content Array send as JSON in the request body
     * @param array $params Array of key => value to replace in service URL
     *
     * @return mixed
     *
     * @throws InvalidMethodException
     * @throws MissingParametersException
     */
    public function put($content = null, $params = array())
    {
        $this->_loadService(Client::PUT, $params);
        $this->getRequest()->setContent(json_encode($content));
        return $this->_callMethod(Client::PUT);
    }

    /**
     * Call DELETE method on a service with the given parameters
     *
     * @param null|array $params Array of key => value to replace in service URL
     *
     * @return mixed
     *
     * @throws InvalidMethodException
     */
    public function delete($params = array())
    {
        $this->_loadService(Client::DELETE, $params);
        return $this->_callMethod(Client::DELETE);
    }

    /**
     * Authenticate for ws call
     *
     * @param string $username
     * @param string $password
     * @param string|AdapterInterface $adapter
     *
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function authenticate($username = null, $password = null, $adapter = 'OAuth2')
    {
        $this->_loadAuthAdaptor($adapter);
        if (is_null($username) || is_null($password)) {
            $config = $this->getRestConfig();
            if (isset($config['access_token']) && !empty($config['access_token'])) {
                return $this->_auth_adaptor->setToken($config['access_token']);
            } else if (isset($config['authentication'])) {
                $username = $config['authentication']['username'];
                $password = $config['authentication']['password'];
                return $this->_auth_adaptor->authenticate($this, $username, $password);
            } else {
                throw new AuthenticationException('No credential provided or found in the configuration');
            }
        } else {
            return $this->_auth_adaptor->authenticate($this, $username, $password);
        }
    }

    /**
     * Call auth clearing function of the auth adaptor
     *
     * @param string|AdapterInterface $adapter
     *
     * @return bool
     */
    public function clearAuthentication($adapter = 'OAuth2')
    {
        $this->_loadAuthAdaptor($adapter);
        if (!empty($this->_auth_adaptor)) {
            $this->_auth_adaptor->clearAuthentication();
        }
        unset($this->_auth_adaptor);
        return true;
    }

    /**
     * Store given params and init HttpClient
     *
     * @param array $config
     *
     * @throws MissingParametersException
     */
    public function init($config = array())
    {
        $config = (empty($config) && !is_null($this->getServiceLocator()) ? $this->getRestConfig() : $config);
        if (empty($config))
            throw new MissingParametersException('No rest configuration could be found.');

        $this->_initHeaders();
        $this->_initHttpConfig($config);
        $this->_storeConfig($config);
        $this->_initHttpClient();
        $this->_initCache();
    }

    /**
     * Enable or disable cache
     *
     * @param bool $enable
     */
    public function enableCache($enable = true)
    {
        $this->cache_enable = (bool)$enable;
    }

    /**
     * Enable or disable cache
     *
     * @param array $options
     */
    public function setCacheOptions($options = array())
    {
        $this->cache_options = array_merge($options, $this->cache_options);
    }

    /**
     * @inheritdoc
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->servicesLocator = $serviceLocator;
        if (empty($this->_rest_config)) {
            $this->_rest_config = $serviceLocator->get('config')['rest'];
        }
    }

    /**
     * @inheritdoc
     */
    public function getServiceLocator()
    {
        return $this->servicesLocator;
    }

    /**
     * Init default headers
     */
    private function _initHeaders()
    {
        $this->setHeaders(array(
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'platform_id' => '2'
        ));
    }

    /**
     * Init Http\Client default config in 'http_config' node
     *
     * @param array $config
     */
    private function _initHttpConfig($config)
    {
        //Default Http timeou
        $this->config['timeout'] = 60;

        //Set HTTP config if some has been given
        if (isset($config['http_config'])) {
            $this->config = array_merge($this->config, $config['http_config']);
        }
    }

    /**
     * Store the config in the current object
     *
     * @param $config
     *
     * @throws AuthenticationException
     * @throws InvalidWsUrlException
     */
    private function _storeConfig($config)
    {
        //Store API URL
        if (isset($config['api_url'])) {
            $this->_api_url = $config['api_url'];
            $this->setUri($this->_api_url);
        } else {
            throw new InvalidWsUrlException('No valid URL for the API to call has been found/given.');
        }

        //Store API Authentication
        if (isset($config['token'])) {
            $this->_access_token = $config['access_token'];
        } else if (empty($this->_access_token)) {
            //@TODO load token from the session
//            throw new AuthenticationException('No OAuth2 token has been given please authenticate to get a token');
        }

        return $this->_rest_config = $config;
    }

    /**
     * Initialize the auth adapter requested
     *
     * @param string $adapter
     *
     * @throws AuthenticationException
     */
    private function _loadAuthAdaptor($adapter)
    {
        if (!isset($this->_auth_adaptor)) {
            if (is_string($adapter)) {
                $classname = __NAMESPACE__ . '\\Authentication\\Adapter\\' . $adapter . 'Adapter';
                if (!class_exists($classname))
                    throw new AuthenticationException('The authentication adapter ' . $adapter . ' was not found.');
                $this->_auth_adaptor = new $classname($this);
            } else {
                $this->_auth_adaptor = $adapter;
            }
        }
    }

    /**
     * Init the Http Client witht the config stored in _init()
     */
    private function _initHttpClient()
    {
        $this->setUri($this->_api_url);
        if (!empty($this->_http_options))
            $this->setOptions($this->_http_options);
    }

    /**
     * Call an the REST API with the requested method
     *
     * @param string $method An Http method to call (GET, POST...)
     *
     * @return mixed
     *
     * @throws AuthenticationException
     * @throws InvalidMethodException
     * @throws ServiceErrorException
     */
    private function _callMethod($method)
    {
        if ($this->_methodAllowed($method)) {
            if (!$this->disable_auth)
                $this->authenticate();
            $this->setMethod($method);
            if ($this->isCacheEnable() && $this->cache->hasItem($this->getCacheID())) {
                $result = unserialize($this->cache->getItem($this->getCacheID()));
            } else {
                $result = $this->send();
                if ($this->isCacheEnable()) {
                    $this->cache->setItem($this->getCacheID(), serialize($result));
                }
            }
            if (in_array($result->getStatusCode(), [200, 201, 422])) {
                return $this->_postCall($result);
            } else {
                $this->_handleCallErrors($result);
            }
        } else {
            throw new InvalidMethodException('Method ' . $method . ' is not allowed for this service.');
        }
    }

    /**
     * Post call treatment convert JSON to stdClass if needed
     *
     * @param \Zend\Http\Response $result
     *
     * @return mixed
     */
    public function _postCall($result)
    {
        $response = $result->getBody();
        if (in_array(substr($response, 0, 1), ['{', '[', '"'])) {
            $response = json_decode($response);
        }
        return $response;
    }

    /**
     * Handle the call responses with status other than 200
     *
     * @param \Zend\Http\Response $result
     *
     * @throws AuthenticationException
     * @throws ServiceErrorException
     */
    private function _handleCallErrors($result)
    {
        if ($result->getStatusCode() == 403) {
            $this->clearAuthentication();
            throw new AuthenticationException('Authentication error. The authentication has been cleared from session, retry authenticating.');
        } else {
            throw new ServiceErrorException('Call error : (' . $result->getStatusCode() . ') ' . $result->getReasonPhrase(), $result->getStatusCode());
        }
    }

    /**
     * Check if method is declared in the current model
     *
     * @param string $method
     *
     * @return bool
     */
    private function _methodAllowed($method)
    {
        return in_array(strtoupper($method), array_keys($this->services));
    }


    /**
     * Format the service URI with the params given
     *
     * @param string     $method       The Http method used GET, POST, PUT...
     * @param null|array $query_params An array of params to complete the service URI if needed
     *
     * @throws MissingParametersException When a required param has been given
     */
    private function _loadService($method, $query_params = array())
    {
        $this->service = null;
        if (isset($this->services[$method]) && !empty($this->services[$method])) {
            $this->service = $this->services[$method];
            if (preg_match_all('#:?:([^/]*)#', $this->service, $matches)) {
                $search = $matches[1];
                $missing_params = $this->_checkParams($search, $query_params, $matches[0]);
                //If all parameters required have been given
                if (empty($missing_params)) {
                    array_walk($search, array($this, '_formatSearchParams'), $matches[0]);
                    array_walk($query_params, array($this, '_formatReplaceParams'), $matches[0]);
                    $replace = array_values($query_params);
                    $this->service = preg_replace($search, $replace, $this->services[$method]);
                } else {
                    throw new MissingParametersException('Some parameters are missing to call this service : ' . implode(', ', $missing_params));
                }
            }
            $this->setUri($this->_api_url . $this->service);
        }
    }

    /**
     * Verify that all required params have been given and return the missing ones
     *
     * @param array $search
     * @param array $params
     * @param array $optional
     *
     * @return array
     */
    private function _checkParams(&$search, $params, $optional = array())
    {
        $missing = array();
        foreach ($search as $param) {
            //If param isn't optional and the param hasn't been givens
            if (!in_array('::' . $param, $optional) && !isset($params[$param])) {
                $missing[] = $param;
            }
        }
        return $missing;
    }

    /**
     * Return the param with ":" before it ex: 'param' -> ':param'
     *
     * @param string $param
     * @param int $key
     * @param array $optional
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function _formatSearchParams(&$param, $key, &$optional)
    {
        $param = '#' . (in_array('::' . $param, $optional) ? '/::' : ':') . $param . '#';
    }

    /**
     * Return the param with ":" before it ex: 'param' -> ':param'
     *
     * @param string $value
     * @param string $param
     * @param array $optional
     */
    public function _formatReplaceParams(&$value, $param, &$optional)
    {
        //If it's an optional param we had a '/' before it to
        if (in_array('::' . $param, $optional)
            && (!empty($value))
        ) {
            $value = '/' . $value;
        }
    }

    /**
     * Generate cache ID
     *
     * @return string
     */
    protected function getCacheID()
    {
        return sha1($this->getRequest()->getMethod() . '-' . $this->_api_url . $this->service . $this->getRequest()->getContent());
    }

    /**
     * Check if the cache has been enabled for the Rest client and the current service
     *
     * @return bool
     */
    protected function isCacheEnable()
    {
        $isEnabled = isset($this->_rest_config['cache_enable']) && $this->_rest_config['cache_enable'] && $this->cache_enable;
        if ($isEnabled && (!isset($this->cache) || empty($this->cache)))
            $this->_initCache(true);
        return $isEnabled;
    }

    /**
     * Init the Http Client witht the config stored in _init()
     *
     * @param bool $force Force cache initialisation even if it is not enabled
     */
    private function _initCache($force = false)
    {
        if ($force || $this->isCacheEnable()) {
            $cache_dir = $this->_rest_config['cache_dir'];
            if (!is_dir($cache_dir))
                @mkdir($cache_dir, 0755, true);
            $this->cache = StorageFactory::factory(array(
                'adapter' => array(
                    'name' => 'Filesystem',
                    'options' => array_merge(array(
                        'cache_dir' => $cache_dir,
                        'ttl' => 3600
                    ), $this->cache_options),
                ),
                'plugins' => array(
                    'exception_handler' => array(
                        'throw_exceptions' => false
                    )
                ),
            ));
        }
    }
}
