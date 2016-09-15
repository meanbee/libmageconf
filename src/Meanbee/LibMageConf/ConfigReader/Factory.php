<?php

namespace Meanbee\LibMageConf\ConfigReader;

use Meanbee\LibMageConf\ConfigReader;
use Meanbee\LibMageConf\MagentoType;

class Factory
{
    /**
     * @param $configFile
     * @return ConfigReader
     */
    public function create($configFile, $magentoType)
    {
        switch ($magentoType) {
            case MagentoType::MAGENTO_1:
                return new MagentoOne($configFile);
            case MagentoType::MAGENTO_2:
                return new MagentoTwo($configFile);
        }
    }
}