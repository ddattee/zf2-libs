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
        $separator   = '[.\s-]';
        $i18n        = '/^(((\+|00)33)' . $separator . '[0-9]' . $separator . '([0-9]{2}' . $separator . '?){4})$/';
        $local       = '/^(([0-9]{2}' . $separator . '?){5})$/';

        if (preg_match($i18n, $valueString) || preg_match($local, $valueString)) {
            return true;
        }

        $this->error(self::INVALID_TELFR);
        return false;
    }
}
