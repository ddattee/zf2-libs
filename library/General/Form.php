<?php
/**
 * Form class
 *
 * @category  General
 * @package   General
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Form extends \Zend\Form\Form implements ServiceLocatorAwareInterface
{
    protected $serviceLocator = null;

    /**
     * Form constructor.
     *
     * @param $serviceLocator
     * @param null $name
     * @param array $options
     */
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
        foreach ($fields as $field) {
            if (is_array($field)) {
                $this->configureRequired($field);
                $this->configureLayout($field);
            }
            //Add field to the form
            $this->add($field);
        }
        $this->loadInputFilter();
    }

    /**
     * Configure required
     *
     * @param &$field
     */
    protected function configureRequired(&$field)
    {
        //Fields are all required if not set to false
        if ((!isset($field['required']) || $field['required'] != false)
            && (!isset($field['attributes']) || !isset($field['attributes']['required']))
        ) {
            $field['attributes']['required'] = 'required';
            $field['option']['label_options']['requiredSuffix'] = ' *';
        }
    }

    /**
     * Set field layout configuration
     *
     * @param &$field
     */
    protected function configureLayout(&$field)
    {
        //Default layout horizontal configuration
        if (!isset($field['options']['twb-layout'])) {
            $field['options']['twb-layout'] = \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_HORIZONTAL;
            if (!isset($field['options']['column-size']))
                $field['options']['column-size'] = 'sm-9';
            if (!isset($field['options']['label_attributes']) || !isset($field['options']['label_attributes']['class']))
                $field['options']['label_attributes']['class'] = 'col-sm-3';
        }
    }

    /**
     * Load input filter if one exist near the form
     */
    public function loadInputFilter()
    {
        $inpuFilterClass = str_replace('\Form\\', '\Form\InputFilter\\', get_class($this));
        if (class_exists($inpuFilterClass)) {
            $this->setInputFilter($this->getServiceLocator()->get($inpuFilterClass));
        }
    }

    /**
     * Return DB adapter
     *
     * @return Zend\Db\Adapter\Adapter
     */
    public function getDbAdapter()
    {
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
}
