<?php

namespace Masdevs\Passanger\Http\Controllers;

use Masdevs\Passanger\Passport;

class ScopeController
{
    /**
     * Get all of the available scopes for the application.
     *
     * @return Response
     */
    public function all()
    {
        return Passport::scopes();
    }
}
