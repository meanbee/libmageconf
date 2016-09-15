<?php

namespace Meanbee\LibMageConfTest\ConfigReader;

use Meanbee\LibMageConf\ConfigReader;
use Meanbee\LibMageConf\ConfigReader\MagentoTwo;
use VirtualFileSystem\FileSystem;

class MagentoTwoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Meanbee\LibMageConf\Exception\FileNotFound
     */
    public function testFileDoesntExist()
    {
        $fs = new FileSystem();
        $fs->createFile("/env.php", $this->getExampleEnvPhpContent());

        new MagentoTwo($fs->path("/env123.php"));
    }

    /**
     * @test
     * @dataProvider providerTestAccessors
     */
    public function testAccessors($method, $expectedValue)
    {
        $fs = new FileSystem();
        $fs->createFile("/env.php", $this->getExampleEnvPhpContent());

        $configReader = new MagentoTwo($fs->path("/env.php"));

        if (!method_exists($configReader, $method)) {
            $this->fail(sprintf("Expected method %s to exist, but it didn't", $method));
        }

        $this->assertEquals($expectedValue, $configReader->$method());
    }

    /**
     * @test
     */
    public function testDatabasePortParsing()
    {
        $fs = new FileSystem();
        $fs->createFile("/env.php", $this->getExampleEnvPhpWithPortContent());

        $configReader = new MagentoTwo($fs->path("/env.php"));

        $this->assertEquals("1989", $configReader->getDatabasePort());
        $this->assertEquals("db", $configReader->getDatabaseHost());
    }

    /**
     * @return string
     */
    protected function getExampleEnvPhpContent()
    {
        return $this->loadFixtureToString("exampleEnvPhp.php");
    }

    /**
     * @return string
     */
    protected function getExampleEnvPhpWithPortContent()
    {
        return $this->loadFixtureToString("exampleEnvPhpWithDatabasePort.php");
    }

    protected function loadFixtureToString($filename)
    {
        return file_get_contents(join(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            "etc",
            $filename
        ]));
    }

    public function providerTestAccessors()
    {
        $pairs = [
            'getDatabaseHost'     => 'db',
            'getDatabasePort'     => '',
            'getDatabaseUsername' => 'magento2user',
            'getDatabasePassword' => 'magento2pass',
            'getDatabaseName'     => 'magento2dbname',
            'getAdminFrontName'   => 'admin_139p1v',
            'getInstallDate'      => 'Tue, 13 Sep 2016 10:18:06 +0000'
        ];

        $formatted = [];

        foreach ($pairs as $key => $value) {
            $formatted[] = [$key, $value];
        }

        return $formatted;
    }
}