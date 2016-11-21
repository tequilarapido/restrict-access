<?php

namespace Tequilarapido\RestrictAccess\Restricter;

trait IpHelper
{
    /**
     * Returns client IP.
     * If a proxy used this returns X_FORWARDED_FOR IP.
     *
     * @return string
     */
    protected function getClientIp()
    {
        return $this->request->getClientIp();
    }

    /**
     * Checks client IP against allowed ips.
     *
     * @param $clientIp
     *
     * @return bool
     *
     * @throws \Exception
     */
    protected function isAllowed($clientIp)
    {
        $allowedIps = $this->getAllowedIps();

        foreach ($allowedIps as $allowedIp) {
            if ($this->ipEqualOrInRange($clientIp, $allowedIp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns allowed Ips from config.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function getAllowedIps()
    {
        $allowedIps = config('restrict_access.by_ip.except');

        if (is_string($allowedIps)) {
            $allowedIps = $this->commaSepratedValues($allowedIps);
        }

        if (! is_array($allowedIps) || empty($allowedIps)) {
            throw new \Exception('restrict_access.by_ip.except is required and must be an array of Ips and/or Ip ranges');
        }

        return $allowedIps;
    }

    /**
     * Quick way to check if the given ip is a range.
     *
     * @param $ipRange
     *
     * @return bool
     */
    protected function isARange($ipRange)
    {
        return strpos($ipRange, '/') !== false;
    }

    /**
     * Compare a given ip against an ip or a an ip range.
     *
     * @param $ip
     * @param $ipOrRange
     *
     * @return bool
     */
    protected function ipEqualOrInRange($ip, $ipOrRange)
    {
        return $this->isARange($ipOrRange) ?
            $this->ipInRange($ip, $ipOrRange) :
            $ip === $ipOrRange;
    }

    /**
     * Checks if a given ip belongs to an ip Range.
     *
     * @param $ip
     * @param $range
     *
     * @return bool
     */
    protected function ipInRange($ip, $range)
    {
        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask; // nb: in case the supplied subnet wasn't correctly aligned
        return ($ip & $mask) == $subnet;
    }

    private function commaSepratedValues($csv, $trim = true)
    {
        $items = ! empty($csv) && is_string($csv)
            ? explode(',', $csv)
            : [];

        if ($trim) {
            $items = array_map(function ($item) {
                return trim($item);
            }, $items);
        }

        return array_filter($items);
    }
}
