<?php

namespace Adamnicholson\Adamlang\Functions;

class ModFunctionTest extends \PHPUnit_Framework_TestCase
{
    public function test_mod()
    {
        $this->assertEquals(0, (new ModFunction)->__invoke(3, 3));
    }
}