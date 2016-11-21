<?php

namespace Tequilarapido\RestrictAccess\Restricter;

use Symfony\Component\HttpFoundation\Response;

class BasicAuthRestricter extends Restricter
{
    /**
     * Do we need to restric.
     */
    public function isRestrictionEnabled()
    {
        return config('restrict_access.by_basic_auth.enabled');
    }

    /**
     * Protection method.
     *
     * @return Response|bool
     */
    public function restrict()
    {
        if (! $this->isRestrictionEnabled()) {
            return false;
        }

        if (! $this->attempt()) {
            return $this->getBasicAuthenticationResponse();
        }

        return false;
    }

    /**
     * Attempt login.
     *
     * @return bool
     *
     * @throws \Exception
     */
    protected function attempt()
    {
        $username = config('restrict_access.by_basic_auth.username');
        $password = config('restrict_access.by_basic_auth.password');

        if (empty($username) || empty($password)) {
            throw new \Exception('restrict_access.by_basic_auth username and password are required');
        }

        $this->ensurePhpFpmCompatibility();

        return $username === $this->request->getUser() && $password === $this->request->getPassword();
    }

    /**
     * Returns www-authenticate header.
     *
     * @return Response
     */
    protected function getBasicAuthenticationResponse()
    {
        $headers = ['WWW-Authenticate' => 'Basic realm="Authentication System"'];

        return new Response('Invalid credentials.', 401, $headers);
    }

    /**
     * PHP FPM / FastCGI Compatibility
     * use custom headers.
     */
    protected function ensurePhpFpmCompatibility()
    {
        $this->tryToSetAuthPHPFrom('Authorization');
        $this->tryToSetAuthPHPFrom('REDIRECT_HTTP_AUTHORIZATION');
    }

    /**
     * Set headers.
     *
     * @param $header
     */
    protected function tryToSetAuthPHPFrom($header)
    {
        if (
            ! empty($_SERVER[$header])
            && preg_match('/Basic\s+(.*)$/i', $_SERVER[$header], $auth_matches)
        ) {
            $auth_items = isset($auth_matches[1]) ? explode(':', base64_decode($auth_matches[1])) : [];
            if (isset($auth_items[0]) && isset($auth_items[1])) {
                $_SERVER['PHP_AUTH_USER'] = strip_tags($auth_items[0]);
                $_SERVER['PHP_AUTH_PW'] = strip_tags($auth_items[1]);
            }
        }
    }
}
