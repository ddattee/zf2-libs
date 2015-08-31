<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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
