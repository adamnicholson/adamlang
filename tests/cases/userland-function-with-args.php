<?php
$code = <<<ADAMLANG
fn "myfunction" "arg1" "arg2" {print "my function was called with " :arg1 " and " :arg2}
call "myfunction" "fizz" "buzz"
print EOL
fn "quote" "string" {print "'" :string "'"}
quote "hello world"
ADAMLANG;
$output = <<<TEXT
my function was called with fizz and buzz
'hello world'
TEXT;
