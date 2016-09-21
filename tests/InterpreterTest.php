<?php

namespace Adamnicholson\Adamlang;

class InterpreterTest extends \PHPUnit_Framework_TestCase
{
    /** @var Interpreter */
    private $interpreter;

    public function setUp()
    {
        $this->interpreter = new Interpreter;

    }

    public function test_print()
    {
        $code = <<<CODE
Print "hello"
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("hello", $out->readAll());
    }

    public function test_shout()
    {
        $code = <<<CODE
Shout "hello"
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("HELLO", $out->readAll());
    }

    public function test_print_twice()
    {
        $this->markTestSkipped();
        $code = <<<CODE
Print "hello"
Print "bar"
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("hellobar", $out->readAll());
    }
}
