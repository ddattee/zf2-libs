<?php
/**
 * Authentication Adapter interface
 *
 * @category  Rest
 * @package   Rest\Authentication
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Rest\Authentication;

interface AdapterInterface
{

    /**
     * Check if authentication for the given credential is still valid
     * @param null|mixed $credential
     * @return boolean
     */
    public function isAuthenticated($credential = null);

    /**
     * Reset current authentication in session
     * @return mixed
     */
    public function clearAuthentication();
}
