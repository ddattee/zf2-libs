<?php
/**
 * Translation view helper
 *
 * @category  General
 * @package   General\View\Helper
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\View\Helper;

use Zend\I18n\Exception;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;

/**
 * View helper for translating messages.
 */
class _ extends AbstractTranslatorHelper
{
    /**
     * Translate a message
     *
     * @param  string $message
     * @param  string $textDomain
     * @param  string $locale
     * @throws Exception\RuntimeException
     * @return string
     */
    public function __invoke($message, $textDomain = null, $locale = null)
    {
        $translator = $this->getTranslator();
        if (null === $translator) {
            throw new Exception\RuntimeException('Translator has not been set');
        }
        if (null === $textDomain) {
            $textDomain = $this->getTranslatorTextDomain();
        }

        return $translator->translate($message, $textDomain, $locale);
    }
}
