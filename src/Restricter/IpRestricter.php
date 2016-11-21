<?php

namespace Tequilarapido\RestrictAccess\Restricter;

use Symfony\Component\HttpFoundation\Response;

class IpRestricter extends Restricter
{
    use IpHelper;

    /**
     * Do we need to restric.
     */
    public function isRestrictionEnabled()
    {
        return config('restrict_access.by_ip.enabled');
    }

    /**
     * Protection method.
     *
     * @return mixed
     */
    public function restrict()
    {
        if (! $this->isRestrictionEnabled()) {
            return false;
        }


        if (! $this->isAllowed($this->getClientIp())) {
            return $this->getNotAllowedResponse();
        }

        return false;
    }

    /**
     * Returns forbidden response.
     *
     * @return Response
     */
    protected function getNotAllowedResponse()
    {
        $headers = ['X-RESTRICT-ACCESS' => 'Not allowed client ip'];

        return new Response('Not allowed.', 403, $headers);
    }
}
