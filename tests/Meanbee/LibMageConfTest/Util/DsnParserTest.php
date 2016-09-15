<?php

namespace Meanbee\LibMageConfTest\Util;

use Meanbee\LibMageConf\Util\DsnParser;
use PHPUnit\Framework\TestCase;

class DsnParserTest extends TestCase
{
    /**
     * @test
     */
    public function testNoHostname()
    {
        $parser = new DsnParser(":1989");

        $this->assertEquals("", $parser->getHost());
        $this->assertEquals("1989", $parser->getPort());
    }

    /**
     * @test
     */
    public function testNoPort()
    {
        $parser = new DsnParser("localhost");

        $this->assertEquals("localhost", $parser->getHost());
        $this->assertEquals("", $parser->getPort());
    }

    /**
     * @test
     */
    public function testBothPresent()
    {
        $parser = new DsnParser("localhost:1989");

        $this->assertEquals("localhost", $parser->getHost());
        $this->assertEquals("1989", $parser->getPort());
    }
}