<?php
$code = <<<ADAMLANG
fn "myfunction" {print "my function was called."}
call "myfunction"
ADAMLANG;
$output = <<<TEXT
my function was called.
TEXT;
