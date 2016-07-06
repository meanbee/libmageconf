<?php

namespace Meanbee\LibMageConf\ConfigReader;

use Meanbee\LibMageConf\ConfigReader;

class Factory
{
    /**
     * @param $configFile
     * @return ConfigReader
     */
    public function create($configFile)
    {
        return new ConfigReader($configFile);
    }
}