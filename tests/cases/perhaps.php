<?php
$code = <<<ADAMLANG
Perhaps true {Print "Value is TRUE!"} {Print "Value is FALSE!"}
Perhaps false {Print "Value is TRUE!"} {Print "Value is FALSE!"}
ADAMLANG;
$output = <<<TEXT
Value is TRUE!Value is FALSE!
TEXT;
