<?php

namespace Meanbee\LibMageConfTest\ConfigReader;

use Meanbee\LibMageConf\ConfigReader;
use Meanbee\LibMageConf\ConfigReader\MagentoOne;
use VirtualFileSystem\FileSystem;

class MagentoOneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Meanbee\LibMageConf\Exception\FileNotFound
     */
    public function testFileDoesntExist()
    {
        $fs = new FileSystem();
        $fs->createFile("/local.xml", $this->getExampleLocalXmlContent());

        new MagentoOne($fs->path("/local123.xml"));
    }

    /**
     * @test
     */
    public function testXpathAccessor()
    {
        $fs = new FileSystem();
        $fs->createFile("/local.xml", $this->getExampleLocalXmlContent());

        $configReader = new MagentoOne($fs->path("/local.xml"));

        $this->assertEquals('d6e6ecf0111111463ffd1a37c3a349e8', $configReader->xpath('//config/global/crypt/key'));
        $this->assertNull($configReader->xpath('//ive/just/made/this/up'));
    }

    /**
     * @test
     * @dataProvider providerTestAccessors
     */
    public function testAccessors($method, $expectedValue)
    {
        $fs = new FileSystem();
        $fs->createFile("/local.xml", $this->getExampleLocalXmlContent());

        $configReader = new MagentoOne($fs->path("/local.xml"));

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
        $fs->createFile("/local.xml", $this->getExampleLocalXmlWithPortContent());

        $configReader = new MagentoOne($fs->path("/local.xml"));

        $this->assertEquals("1989", $configReader->getDatabasePort());
        $this->assertEquals("db", $configReader->getDatabaseHost());
    }

    /**
     * @return string
     */
    protected function getExampleLocalXmlContent()
    {
        return $this->loadFixtureToString("exampleLocalXml.xml");
    }

    /**
     * @return string
     */
    protected function getExampleLocalXmlWithPortContent()
    {
        return $this->loadFixtureToString("exampleLocalXmlWithDatabasePort.xml");
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
            'getDatabaseUsername' => 'root',
            'getDatabasePassword' => 'toor',
            'getDatabaseName'     => 'magento',
            'getAdminFrontName'   => 'admin',
            'getInstallDate'      => 'Wed, 14 Mar 2012 15:12:29 +0000'
        ];

        $formatted = [];

        foreach ($pairs as $key => $value) {
            $formatted[] = [$key, $value];
        }

        return $formatted;
    }
}