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

class FormLabel extends \Zend\Form\View\Helper\FormLabel
{
    /**
     * Invokable
     *
     * @param ElementInterface|null $element      Form element
     * @param null                  $labelContent Label content
     * @param null                  $position     Element position
     *
     * @return string
     */
    public function __invoke(ElementInterface $element = null, $labelContent = null, $position = null)
    {
        $originalformLabel = parent::__invoke($element, $labelContent, $position);
        return  $originalformLabel . ($element->hasAttribute('required') ? '<span class="required-mark">*</span>' : '');
    }
}
