<?php

/**
 * Validate that a field is a french formated phone number
 *
 * @author ddattee
 */
namespace General\Validator;

use Zend\Validator\AbstractValidator;

class EmailSyntaxe extends AbstractValidator
{

	const INVALID_EMAILSYNT = 'invalidEmailSyntax';

	protected $messageTemplates = array(
		self::INVALID_EMAILSYNT => "'%value%' is not a valid email.",
	);

	public function isValid($value)
	{
		$valueString = strtolower((string)$value);
		$this->setValue($valueString);
		$regex = '/^[a-z0-9_.-]+@[a-z0-9.-]+\.[a-z]{2,}$/';

		if (!preg_match($regex, $valueString)) {
			$this->error(self::INVALID_EMAILSYNT);
			return false;
		}
		return true;
	}
}