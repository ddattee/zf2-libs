<?php
namespace Rest\Authentication\Adapter;

use Rest\Authentication\AdapterInterface;
use Rest\Client;
use Rest\Exception\AuthenticationException;
use Rest\Exception\InvalidAuthenticationException;
use Zend\Session\Container;

class OAuth2Adapter implements AdapterInterface
{
	private $_auth_service = 'auth';
	private $_auth_client;

	protected $session;
	protected $_auth_response;
	protected $_auth_token;

	public function __construct()
	{
		$this->session = new Container(get_class($this));
	}

	/**
	 * Add authentication header to Http client or try to authenticate if no authentication has been done yet
	 * @param Client|null $http_client
	 * @param null|string $username
	 * @param null|string $password
	 * @param string $grant_type
	 * @param string $client_id
	 * @return bool|string
	 * @throws AuthenticationException
	 */
	public function authenticate(Client &$http_client = null, $username = null, $password = null, $grant_type = 'password', $client_id = 'app1j1v')
	{
		$response = false;
		if ($grant_type == 'password' && (!is_null($username) && !is_null($password))) {
			$this->session->auth_params = new \stdClass();
			$this->session->auth_params->username = $username;
			$this->session->auth_params->password = $password;
			$this->session->auth_params->grant_type = $grant_type;
			$this->session->auth_params->client_id = $client_id;
			$response = $this->_doAuthenticate($http_client);
		} else if ($this->isAuthenticated() && $grant_type == 'refresh_token' && !is_null($password)) {
			$this->session->auth_params->password = $password;
			$this->session->auth_params->grant_type = $grant_type;
			$this->session->auth_params->client_id = $client_id;
			$response = $this->_doAuthenticate($http_client);
		} else {
			throw new AuthenticationException('No credentials were provided for the authentication');
		}
		if ($this->isAuthenticated()
			&& $http_client instanceof \Zend\Http\Client
			&& !$http_client->hasHeader('Authorization')
		) {
			$headers = $http_client->getRequest()->getHeaders();
			$headers->addHeaderLine('Authorization', 'Bearer ' . $this->getToken());
		}
		return $response;
	}

	/**
	 * Return the current token stored in session
	 * @param Client $http_client
	 * @return bool|string
	 * @throws InvalidAuthenticationException
	 */
	public function getToken(Client $http_client = null)
	{
		if (isset($this->session->token) && !empty($this->session->token)) {
			if (isset($this->session->token_expire) && !empty($this->session->token_expire)) {
				$now = new \DateTime();
				$expire = unserialize($this->session->token_expire);
				if ($now > $expire) {
					if (isset($this->session->refresh_token)) {
						$this->refreshToken($http_client);
					} else {
						$this->clearAuthentication();
						$this->_doAuthenticate($http_client);
					}
				}
			}
			return $this->session->token;
		} else {
			return false;
		}
	}

	/**
	 * Store given token into session
	 * @param string $token
	 * @param null|int $expirein Number of seconds before token expires
	 */
	public function setToken($token, $expirein = null, $refresh_token = null)
	{
		$this->session->token = $token;
		if (!is_int($expirein)) {
			$expire = new \DateTime();
			$expire->add(new \DateInterval('PT' . (int)$expirein . 'S'));
			$this->session->token_expire = serialize($expire);
		}
		if (!is_null($refresh_token)) {
			$this->session->refresh_token = $refresh_token;
		}
	}

	/**
	 * Check if a access token is accessible
	 * @param null $credential
	 * @return bool
	 */
	public function isAuthenticated($credential = null)
	{
		return ($this->getToken() ? true : false);
	}

	/**
	 * Refresh token if a refresh token exist in session
	 * @param $http_client
	 * @return bool|string
	 * @throws AuthenticationException
	 */
	public function refreshToken($http_client)
	{
		$auth = false;
		if (isset($this->session->refresh_token) && !empty($this->session->refresh_token)) {
			$token = $this->session->refresh_token;
			unset($this->session->refresh_token);
			$auth = $this->authenticate($http_client, null, $token, 'refresh_token');
		}
		return $auth;
	}

	/**
	 * Clear authentication from session
	 */
	public function clearAuthentication()
	{
		unset($this->session->token);
		unset($this->session->token_expire);
		unset($this->session->refresh_token);
		$this->session->getManager()->getStorage()->clear(get_class($this));
	}

	/**
	 * Handle the authentication result and store the result in session
	 * @param Client $http_client
	 * @return mixed
	 * @throws AuthenticationException
	 */
	private function _doAuthenticate(Client $http_client)
	{
		$this->_prepareAuthentication($http_client);
		$result = $this->_auth_client->send();
		if ($result->isSuccess()) {
			$response = $result->getBody();
			if (substr($response, 0, 1) == '{') {
				$response = json_decode($response);
				//Store the auth token in session
				$this->setToken($response->access_token, $response->expires_in, $response->refresh_token);
			}
			return $response;
		} else {
			throw new AuthenticationException('Error during authentication (' . $result->getStatusCode() . ') ' . $result->getContent());
		}
	}

	/**
	 * Prepare authentication request
	 * @param Client $http_client
	 */
	private function _prepareAuthentication(Client $http_client, $refresh = false)
	{
		$this->_auth_client = new Client();
		$this->_auth_client->setUri($http_client->getUri()->getScheme() . '://' . $http_client->getUri()->getHost() . '/' . $this->_auth_service);
		$this->_auth_client->setMethod('POST');
		$this->_auth_client->setRawBody(json_encode($this->_prepareAuthData()));
		$headers = $this->_auth_client->getRequest()->getHeaders();
		$headers->addHeaderLine('Accept', 'application/json');
		$headers->addHeaderLine('Content-Type', 'application/json');
		$headers->addHeaderLine('platform_id', 1);
	}

	/**
	 * Prepare auth data for the body ot the auth request
	 * @param bool|false $refresh
	 * @return array
	 */
	private function _prepareAuthData($refresh = false)
	{
		$data = array(
			'client_id' => $this->session->auth_params->client_id,
			'grant_type' => $this->session->auth_params->grant_type
		);
		if ($refresh) {
			$data['refresh_token'] = $this->session->auth_params->password;
		} else {
			$data['username'] = $this->session->auth_params->username;
			$data['password'] = $this->session->auth_params->password;
		}
		return $data;
	}

}
