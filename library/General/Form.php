<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 29/06/2015
 * Time: 15:01
 */

namespace General;


use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Form extends \Zend\Form\Form implements ServiceLocatorAwareInterface
{
	protected $serviceLocator = null;

	public function __construct($serviceLocator, $name = null, $options = array())
	{
		//Store ServiceLocator
		$this->setServiceLocator($serviceLocator);
		//Build standard ZF
		$construct = parent::__construct($name, $options);
		//Build the form if a build function has been created
		if (method_exists($this, 'build')) {
			$this->build();
		}
		return $construct;
	}

	/**
	 * @inheritdoc
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

	/**
	 * @inheritdoc
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}

	/**
	 * Load fields into the form from the array of definition and add default behaviour
	 * @param array $fields
	 */
	protected function loadFields($fields)
	{
		foreach ($fields as $f) {
			if (is_array($f)) {
				//Fields are all required if not set to false
				if ((!isset($f['required']) || $f['required'] != false)
					&& (!isset($f['attributes']) || !isset($f['attributes']['required']))
				) {
					$f['attributes']['required'] = 'required';
					$f['option']['label_options']['requiredSuffix'] = ' *';
				}

				//Default layout horizontal configuration
				if (!isset($f['options']['twb-layout'])) {
					$f['options']['twb-layout'] = \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_HORIZONTAL;
					if (!isset($f['options']['column-size']))
						$f['options']['column-size'] = 'sm-9';
					if (!isset($f['options']['label_attributes']) || !isset($f['options']['label_attributes']['class']))
						$f['options']['label_attributes']['class'] = 'col-sm-3';
				}
			}
			//Add field to the form
			$this->add($f);
		}
		$this->loadInputFilter();
	}

	/**
	 * Load input filter if one exist near the form
	 */
	public function loadInputFilter()
	{
		$inpuFilterClass = str_replace('\Form\\', '\Form\InputFilter\\', get_class($this));
		if (class_exists($inpuFilterClass)) {
			$this->setInputFilter(new $inpuFilterClass());
		}
	}
}