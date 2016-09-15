<?php

namespace Meanbee\LibMageConf\Util;

class DsnParser
{
    /**
     * @param $dsnString
     */
    public function __construct($dsnString)
    {
        $this->dsn = $dsnString;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->getDsnParts()['port'];
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->getDsnParts()['host'];
    }

    /**
     * @return array
     */
    protected function getDsnParts()
    {
        $colonPosition = strrpos($this->dsn, ':');

        if ($colonPosition === false) {
            $host = $this->dsn;
            $port = '';
        } else {
            $host = substr($this->dsn, 0, $colonPosition);
            $port = substr($this->dsn, $colonPosition + 1);
        }

        return [
            'host' => $host,
            'port' => $port
        ];
    }
}