<?php
/**
 * Add css class to form error element
 *
 * @category  General
 * @package   General\Form\View\Helper
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Form\View\Helper;

use TwbBundle\Form\View\Helper\TwbBundleFormElementErrors;

class FormElementErrors extends TwbBundleFormElementErrors
{
    protected $attributes = array(
        'class' => 'help-block list-unstyled'
    );
}
