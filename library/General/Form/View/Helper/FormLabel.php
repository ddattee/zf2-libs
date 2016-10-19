<?php
/**
 * Add required suffix to required element
 *
 * @category  General
 * @package   General\Form\View\Helper
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Form\View\Helper;

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
