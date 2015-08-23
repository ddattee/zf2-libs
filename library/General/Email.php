<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 29/06/2015
 * Time: 15:01
 */

namespace General;


use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class Email extends Message implements ServiceLocatorAwareInterface, AbstractFactoryInterface
{
	use ServiceLocatorAwareTrait;

	protected $layout = '';
	protected $config = array();

	/**
	 * Set layout, can be a filepath or HTML string
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	/**
	 * Get Layout
	 * @return mixed
	 */
	public function getLayout()
	{
		return $this->layout;
	}

	/**
	 * Get template content
	 * @param string $templatename
	 * @param array $data
	 * @return string
	 */
	public function loadContent($templatename, array $data)
	{
		$templatepath = $this->config['templates']['path'] . '/templates/' . $templatename;
		array_walk($data, array($this, 'formatTags'));
		$search = array_keys($data);
		array_walk($search, array($this, 'formatKey'));
		return str_replace($search, array_values($data), file_get_contents($templatepath));
	}

	/**
	 * Load snippets if any detected
	 * @param mixed $value
	 * @param string $name
	 */
	public function formatTags(&$value, $name)
	{
		if (strstr($name, '_'))
			$this->loadSnippet(substr($name, 0, strpos($name, '_')), $value);
	}

	/**
	 * Add % around the tags
	 * @param string $name
	 */
	public function formatKey(&$name)
	{
		$name = "%$name%";

	}

	/**
	 * Load snippet if it exists
	 * @param string $name
	 * @param mixed $data
	 */
	private function loadSnippet($name, &$data)
	{
		$snippetfile = $this->config['templates']['path'] . '/snippets/' . $name . '.phtml';
		if (file_exists($snippetfile)) {
			ob_start();
			include $snippetfile;
			$data = ob_get_clean();
		}
	}

	/**
	 * Return layout HTML
	 * @return string
	 */
	public function getLayoutContent()
	{
		if (file_exists($this->layout))
			return file_get_contents($this->layout);
		return $this->getLayout();
	}

	/**
	 * Set the bod into the layout
	 * @param null|object|string|\Zend\Mime\Message $html
	 * @return Message
	 */
	public function setBody($html)
	{
		$content = str_replace('%content%', $html, $this->getLayoutContent());
		$htmlpart = new Part($content);
		$htmlpart->type = "text/html";
		$txtpart = new Part(strip_tags($html));
//		$txtpart->type = "text/plain";
		$body = new \Zend\Mime\Message();
		$body->setParts(array($htmlpart));
		return parent::setBody($body);
	}

	/**
	 * Init transport and send the email
	 */
	public function send()
	{
		$smtpconfig = new SmtpOptions();
		$smtpconfig
			->setName($this->config['smtp']['name'])
			->setHost($this->config['smtp']['host'])
			->setPort($this->config['smtp']['port'])
			->setConnectionClass($this->config['smtp']['connection_class'])
			->setConnectionConfig($this->config['smtp']['connection_config']);
		$transport = new Smtp($smtpconfig);
		return $transport->send($this);
	}

	/**
	 * @inheritdoc
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		return ('General\Email' === $requestedName);
	}

	/**
	 * @inheritdoc
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		$email = new $requestedName($serviceLocator);
		$email->setServiceLocator($serviceLocator);
		$email->init();
		return $email;
	}

	public function init()
	{
		$this->config = $this->getServiceLocator()->get('config')['email'];
		if (!empty($this->config['templates']['layout']))
			$this->setLayout($this->config['templates']['path'] . '/' . $this->config['templates']['layout']);
	}

}