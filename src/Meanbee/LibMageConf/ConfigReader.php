<?php

namespace Meanbee\LibMageConf;

use Meanbee\LibMageConf\Exception\FileNotFound;

class ConfigReader
{
    protected $configFile;
    protected $xmlDoc;

    public function __construct($configFile)
    {
        $this->configFile = $configFile;

        if (!file_exists($this->configFile)) {
            throw new FileNotFound(
                sprintf("Unable to find config file at %s", $this->configFile)
            );
        }
    }

    /**
     * @return \SimpleXMLElement
     */
    protected function getXmlDoc()
    {
        if ($this->xmlDoc === null) {
            $this->xmlDoc = new \SimpleXMLElement(file_get_contents($this->configFile));
        }

        return $this->xmlDoc;
    }

    /**
     * @param $xpath
     * @return null|string
     */
    public function xpath($xpath)
    {
        $result = $this->getXmlDoc()->xpath($xpath);

        if (count($result) > 0) {
            return (string) $result[0];
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getDatabaseHost()
    {
        return $this->getDatabaseHostComponents()['host'];
    }

    /**
     * @return null|string
     */
    public function getDatabasePort()
    {
        return $this->getDatabaseHostComponents()['port'];
    }

    /**
     * @return null|string
     */
    public function getDatabaseUsername()
    {
        return $this->xpath('//config/global/resources/default_setup/connection/username');
    }

    /**
     * @return null|string
     */
    public function getDatabasePassword()
    {
        return $this->xpath('//config/global/resources/default_setup/connection/password');
    }

    /**
     * @return null|string
     */
    public function getDatabaseName()
    {
        return $this->xpath('//config/global/resources/default_setup/connection/dbname');
    }

    /**
     * @return null|string
     */
    public function getInstallDate()
    {
        return $this->xpath('//config/global/install/date');
    }

    /**
     * @return null|string
     */
    public function getAdminFrontName()
    {
        return $this->xpath('//config/admin/routers/adminhtml/args/frontName');
    }

    /**
     * @return array
     */
    protected function getDatabaseHostComponents()
    {
        $rawHost = $this->xpath('//config/global/resources/default_setup/connection/host');
        $colonPosition = strrpos($rawHost, ':');

        if ($colonPosition === false) {
            $host = $rawHost;
            $port = '';
        } else {
            $host = substr($rawHost, 0, $colonPosition);
            $port = substr($rawHost, $colonPosition + 1);
        }

        return [
            'host' => $host,
            'port' => $port
        ];
    }
}