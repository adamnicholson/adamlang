<?php

namespace Adamnicholson\Adamlang;

class TestCasesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $case
     * @dataProvider cases
     */
    public function test_case($case)
    {
        require $case;

        $return = (new \Adamnicholson\Adamlang\Interpreter)->run(
            new \Adamnicholson\Adamlang\IO\InMemoryIO($code),
            $in = new \Adamnicholson\Adamlang\IO\InMemoryIO,
            $out = new \Adamnicholson\Adamlang\IO\InMemoryIO
        );

        $this->assertEquals($output, $out->readAll());
    }

    public function cases()
    {
        return array_map(function ($file) {
            return [$file];
        }, glob(__DIR__ . "/cases/*.php"));
    }
}
