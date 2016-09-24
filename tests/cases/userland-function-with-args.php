<?php
$code = <<<ADAMLANG
fn "myfunction" "arg1" "arg2" {print "my function was called with " :arg1 " and " :arg2}
call "myfunction" "fizz" "buzz"
ADAMLANG;
$output = <<<TEXT
my function was called with fizz and buzz
TEXT;
