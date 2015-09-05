<?php
namespace General\View\Helper\Form;


use TwbBundle\Form\View\Helper\TwbBundleFormElementErrors;

class FormElementErrors extends TwbBundleFormElementErrors
{
	protected $attributes = array(
		'class' => 'help-block list-unstyled'
	);
}
