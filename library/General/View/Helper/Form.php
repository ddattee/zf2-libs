<?php
/**
 * Form view helper
 *
 * @category  General
 * @package   General\View\Helper
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\View\Helper;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\FormInterface;
use Zend\View;
use Zend\View\Exception;

class  Form extends TwbBundleForm
{
    const LAYOUT_DEFAULT = '';

    public function __invoke(FormInterface $oForm = null, $sFormLayout = self::LAYOUT_DEFAULT)
    {
        return parent::__invoke($oForm, $sFormLayout);
    }

    public function render(FormInterface $oForm, $sFormLayout = self::LAYOUT_DEFAULT)
    {
        return parent::render($oForm, $sFormLayout);
    }

    protected function setFormClass(FormInterface $oForm, $sFormLayout = self::LAYOUT_DEFAULT)
    {
        return parent::setFormClass($oForm, $sFormLayout);
    }
}
