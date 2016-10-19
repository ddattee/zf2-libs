<?php
/**
 * Validate that a field is a french formated phone number
 *
 * @category  General
 * @package   General\Validator
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Validator;

use Zend\Validator\AbstractValidator;

class TelFr extends AbstractValidator
{

    const INVALID_TELFR = 'invalidTelFr';

    protected $messageTemplates = array(
        self::INVALID_TELFR => "'%value%' is not a valid telephone number.",
    );

    public function isValid($value)
    {
        $valueString = (string)$value;
        $this->setValue($valueString);
        $regex = '/^(\+33\s)?([0-9]{2}\s?){5,}$/';

        if (!preg_match($regex, $valueString)) {
            $this->error(self::INVALID_TELFR);
            return false;
        }
        return true;
    }
}
