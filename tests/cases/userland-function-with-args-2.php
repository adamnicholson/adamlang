<?php
$code = <<<ADAMLANG
fn "quote" "string" {print "'" :string "'"}
quote "hello world"
ADAMLANG;
$output = <<<TEXT
'hello world'
TEXT;
