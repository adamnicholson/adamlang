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

    public function test_scalars_can_be_returned()
    {
        $code = <<<CODE
Return "fizzybuzzy"
CODE;
        $code = new InMemoryIO($code);

        $returns = $this->interpreter->run($code, new InMemoryIO, new InMemoryIO);
        $this->assertEquals("fizzybuzzy", $returns);
    }

    public function test_booleans()
    {
        $code = <<<CODE
Return true
CODE;
        $code = new InMemoryIO($code);

        $returns = $this->interpreter->run($code, new InMemoryIO, new InMemoryIO);
        $this->assertEquals(true, $returns);
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

    public function test_infinite_layers_of_nested_functions()
    {
        $code = <<<CODE
Print (Concat (Lorem) " - " (Concat (Lorem) "!!!")) "~~" (Lorem)
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("lorem ipsum - lorem ipsum!!!~~lorem ipsum", $out->readAll());
    }

    public function test_loops()
    {
        $code = <<<CODE
Loop "5" {Print "1"}
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("11111", $out->readAll());
    }

    public function test_conditionals()
    {
        $code = <<<CODE
Perhaps true {Print "1"} {Print "2"}
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("1", $out->readAll());
    }


    public function test_conditional_else_statements()
    {
        $code = <<<CODE
Perhaps false {Print "1"} {Print "2"}
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("2", $out->readAll());
    }

    public function test_conditionals_can_handle_expressions()
    {
        $code = <<<CODE
Perhaps {Return false} {Print "1"} {Print "2"}
CODE;
        $code = new InMemoryIO($code);

        $this->interpreter->run($code, $in = new InMemoryIO(), $out = new InMemoryIO);
        $this->assertEquals("2", $out->readAll());
    }
}
