<?php
/**
 * Validate email syntaxe with a regex
 *
 * @category  General
 * @package   General\Validator
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Validator;

use Zend\Validator\AbstractValidator;

class EmailSyntaxe extends AbstractValidator
{

    const INVALID_EMAILSYNT = 'invalidEmailSyntax';

    protected $messageTemplates = array(
        self::INVALID_EMAILSYNT => "'%value%' is not a valid email.",
    );

    /**
     * Validate email syntaxe on $value
     *
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $valueString = strtolower((string)$value);
        $this->setValue($valueString);
        $regex = '/^[a-z0-9_.+-]+@[a-z0-9.-]+\.[a-z]{2,}$/';

        if (!preg_match($regex, $valueString)) {
            $this->error(self::INVALID_EMAILSYNT);
            return false;
        }
        return true;
    }
}
