<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 03/07/2015
 * Time: 11:27
 */

namespace General\Form\View\Helper;

use TwbBundle\Form\View\Helper\TwbBundleFormElementErrors;

class FormElementErrors extends TwbBundleFormElementErrors
{
	protected $attributes = array(
		'class' => 'help-block list-unstyled'
	);

}