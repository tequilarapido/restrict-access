<?php

namespace Tequilarapido\RestrictAccess\Restricter;

use Illuminate\Http\Request;

abstract class Restricter
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Do we need to restrict access ?
     */
    abstract public function isRestrictionEnabled();

    /**
     * Protection method.
     *
     * @return mixed
     */
    abstract public function restrict();
}
