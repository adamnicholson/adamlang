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

    public function test_values_can_be_returned()
    {
        $code = <<<CODE
Lorem
CODE;
        $code = new InMemoryIO($code);

        $returns = $this->interpreter->run($code, new InMemoryIO, new InMemoryIO);
        $this->assertEquals("lorem ipsum", $returns);
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

    public function test_with_multiple_args()
    {
        $code = <<<CODE
Print "hello" "world"
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("helloworld", $out->readAll());
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
        $code = <<<CODE
Print "hello"
Print "bar"
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("hellobar", $out->readAll());
    }

    public function test_print_accepts_function_args()
    {
        $code = <<<CODE
Print (Lorem)
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("lorem ipsum", $out->readAll());
    }

    public function test_nested_functions_with_multiple_args()
    {
        $code = <<<CODE
Print (Concat "foo" "bar")
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("foobar", $out->readAll());
    }

    public function test_2_layers_of_nested_functions()
    {
        $code = <<<CODE
Print (Concat (Lorem) "bar")
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("lorem ipsumbar", $out->readAll());
    }
}
