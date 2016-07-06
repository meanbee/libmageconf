<?php

namespace Meanbee\LibMageConfTest;

use Meanbee\LibMageConf\ConfigReader;
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

        $factory = new ConfigReader\Factory();
        $factory->create($fs->path("/local.xml"));
    }
}