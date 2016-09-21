<?php

namespace Adamnicholson\Adamlang;

class InMemoryIOTest extends \PHPUnit_Framework_TestCase
{
    public function test_io()
    {
        $io = new InMemoryIO("");
        $io = $io->write("foo");
        $io = $io->write("bar");
        $this->assertEquals("foobar", $io->readAll());

        $this->assertEquals("f", $io->read());
        $this->assertEquals("o", $io->read());
        $this->assertEquals(false, $io->ended());
        $this->assertEquals("o", $io->read());

        $this->assertEquals("b", $io->peek());
        $this->assertEquals("b", $io->read());
        $this->assertEquals("a", $io->read());
        $this->assertEquals("r", $io->read());
        $this->assertEquals(true, $io->ended());
    }
}
