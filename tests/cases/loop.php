<?php
$code = <<<ADAMLANG
loop "5" {print "Test: " :i EOL}
ADAMLANG;
$output = <<<TEXT
Test: 0
Test: 1
Test: 2
Test: 3
Test: 4

TEXT;
