<?php

namespace Meanbee\LibMageConf\ConfigReader;

use Meanbee\LibMageConf\ConfigReader;
use Meanbee\LibMageConf\Exception\FileNotFound;
use Meanbee\LibMageConf\Util\ArrayQuery;
use Meanbee\LibMageConf\Util\DsnParser;


class MagentoTwo implements ConfigReader
{
    protected $configFile;
    protected $configArray;
    protected $config;

    public function __construct($configFile)
    {
        $this->configFile = $configFile;

        if (!file_exists($this->configFile)) {
            throw new FileNotFound(
                sprintf("Unable to find config file at %s", $this->configFile)
            );
        }

        $this->configArray = include $this->configFile;
        $this->config = new ArrayQuery($this->configArray);
    }


    /**
     * @return null|string
     */
    public function getDatabaseHost()
    {
        return $this->getDsnParser()->getHost();
    }

    /**
     * @return null|string
     */
    public function getDatabasePort()
    {
        return $this->getDsnParser()->getPort();
    }

    /**
     * @return null|string
     */
    public function getDatabaseUsername()
    {
        return $this->getConfigValue('db/connection/default/username');
    }

    /**
     * @return null|string
     */
    public function getDatabasePassword()
    {
        return $this->getConfigValue('db/connection/default/password');
    }

    /**
     * @return null|string
     */
    public function getDatabaseName()
    {
        return $this->getConfigValue('db/connection/default/dbname');
    }

    /**
     * @return null|string
     */
    public function getInstallDate()
    {
        return $this->getConfigValue('install/date');
    }

    /**
     * @return null|string
     */
    public function getAdminFrontName()
    {
        return $this->getConfigValue('backend/frontName');
    }

    /**
     * @param $path
     * @return string
     */
    protected function getConfigValue($path)
    {
        return $this->config->query($path);
    }

    /**
     * @return DsnParser
     */
    protected function getDsnParser()
    {
        $rawHost = $this->getConfigValue('db/connection/default/host');
        return new DsnParser($rawHost);
    }
}