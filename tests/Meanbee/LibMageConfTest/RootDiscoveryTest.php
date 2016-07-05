<?php

namespace Meanbee\LibMageConfTest;

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

        $rootDiscovery = new RootDiscovery($fs->path("/test"));

        $this->assertEquals($fs->path("/test"), $rootDiscovery->getRootDirectory());
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
}