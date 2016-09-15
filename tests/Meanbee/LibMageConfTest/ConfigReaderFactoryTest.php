<?php

namespace Meanbee\LibMageConfTest;

use Meanbee\LibMageConf\ConfigReader;
use Meanbee\LibMageConf\MagentoType;
use VirtualFileSystem\FileSystem;

class ConfigReaderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testReturnsConfigReader()
    {
        $fs = new FileSystem();
        $fs->createFile("/local.xml");
        $fs->createFile("/env.php");

        $factory = new ConfigReader\Factory();

        $m1 = $factory->create($fs->path("/local.xml"), MagentoType::MAGENTO_1);
        $m2 = $factory->create($fs->path("/env.php"), MagentoType::MAGENTO_2);

        $this->assertInstanceOf('\Meanbee\LibMageConf\ConfigReader', $m1);
        $this->assertInstanceOf('\Meanbee\LibMageConf\ConfigReader\MagentoOne', $m1);

        $this->assertInstanceOf('\Meanbee\LibMageConf\ConfigReader', $m2);
        $this->assertInstanceOf('\Meanbee\LibMageConf\ConfigReader\MagentoTwo', $m2);
    }
}