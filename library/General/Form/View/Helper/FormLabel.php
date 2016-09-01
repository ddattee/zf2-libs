<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 03/07/2015
 * Time: 11:27
 */

namespace General\Form\View\Helper;

use TwbBundle\View\Helper\TwbBundleLabel;
use Zend\Form\ElementInterface;

class FormLabel
{
    /**
     * Invokable
     *
     * @param ElementInterface|null $element
     * @param null $labelContent
     * @param null $position
     *
     * @return string
     */
    public function __invoke(ElementInterface $element = null, $labelContent = null, $position = null)
    {

        // invoke parent and get form label
        $originalformLabel = parent::__invoke($element, $labelContent, $position);

        // check if element is required
        if ($element->hasAttribute('required')) {
            // add a start to required elements
            return '<span class="required-mark">*</span>' . $originalformLabel;
        } else {
            // not start to optional elements
            return  $originalformLabel;
        }
    }
}