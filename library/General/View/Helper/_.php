<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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
