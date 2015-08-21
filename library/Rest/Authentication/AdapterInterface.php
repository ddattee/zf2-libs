<?php
namespace Rest\Authentication;

use Rest\Authentication;

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
