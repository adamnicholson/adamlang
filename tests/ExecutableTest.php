<?php

namespace Adamnicholson\Adamlang;

class ExecutableTest extends \PHPUnit_Framework_TestCase
{
    public function test_executes()
    {
        $file = tmpfile();
        fwrite($file, 'print "hello world"');
        $meta_data = stream_get_meta_data($file);
        $filename = $meta_data["uri"];
        $output = shell_exec(__DIR__ . "/../bin/adam " . $filename);
        $this->assertEquals("hello world", $output);
        fclose($file);
    }
}
