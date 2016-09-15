<?php

namespace Meanbee\LibMageConfTest;

use Meanbee\LibMageConf\MagentoType;
use Meanbee\LibMageConf\RootDiscovery;
use VirtualFileSystem\FileSystem;

class RootDiscoveryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testDirectExample()
    {
        $fs = new FileSystem();

        $fs->createDirectory("/test/app/etc", true);
        $fs->createFile("/test/app/etc/local.xml", "example");

        $fs->createDirectory("/test_m2/app/etc", true);
        $fs->createFile("/test_m2/app/etc/env.php", "example");

        $rootDiscovery = new RootDiscovery($fs->path("/test"));
        $rootDiscoveryM2 = new RootDiscovery($fs->path("/test_m2"));

        $this->assertEquals($fs->path("/test"), $rootDiscovery->getRootDirectory());
        $this->assertEquals(MagentoType::MAGENTO_1, $rootDiscovery->getInstallationType());

        $this->assertEquals($fs->path("/test_m2"), $rootDiscoveryM2->getRootDirectory());
        $this->assertEquals(MagentoType::MAGENTO_2, $rootDiscoveryM2->getInstallationType());
    }

    /**
     * @test
     */
    public function testNotFoundExample()
    {
        $fs = new FileSystem();

        $fs->createDirectory("/test/app/etc", true);
        $fs->createFile("/test/app/etc/not_local.xml", "example");

        $rootDiscovery = new RootDiscovery($fs->path("/test"));

        $this->assertNull($rootDiscovery->getRootDirectory());
    }

    /**
     * @test
     */
    public function testOneDeep()
    {
        $fs = new FileSystem();

        $fs->createDirectory("/test/test/app/etc", true);
        $fs->createFile("/test/test/app/etc/local.xml", "example");

        $rootDiscovery = new RootDiscovery($fs->path("/test"));

        $this->assertEquals($fs->path("/test/test"), $rootDiscovery->getRootDirectory());
    }

    /**
     * @test
     */
    public function testTwoDeep()
    {
        $fs = new FileSystem();

        $fs->createDirectory("/test/test/test/app/etc", true);
        $fs->createFile("/test/test/test/app/etc/local.xml", "example");

        $rootDiscovery = new RootDiscovery($fs->path("/test"));

        $this->assertEquals($fs->path("/test/test/test"), $rootDiscovery->getRootDirectory());
    }

    /**
     * @test
     */
    public function testSwimUp()
    {
        $fs = new FileSystem();

        $fs->createDirectory("/test/app/etc", true);
        $fs->createDirectory("/test/media", true);
        $fs->createFile("/test/app/etc/local.xml", "example");

        $rootDiscovery = new RootDiscovery($fs->path("/test/media"));

        $this->assertEquals($fs->path("/test"), $rootDiscovery->getRootDirectory());
    }

    /**
     * @test
     */
    public function testGetConfigReader()
    {
        $fs = new FileSystem();

        $fs->createDirectory("/test/app/etc", true);
        $fs->createFile("/test/app/etc/local.xml", "example");

        $rootDiscovery = new RootDiscovery($fs->path("/test"));

        $this->assertEquals($fs->path("/test"), $rootDiscovery->getRootDirectory());
        $this->assertInstanceOf('Meanbee\LibMageConf\ConfigReader', $rootDiscovery->getConfigReader());
    }
}