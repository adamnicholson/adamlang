<?php
$code = <<<ADAMLANG
fn "isthree" "num" {equals 3 :num}
loop 5 {print "Test: " (perhaps (isthree :i) "THREE" (str :i)) EOL}
ADAMLANG;
$output = <<<TEXT
Test: 0
Test: 1
Test: 2
Test: THREE
Test: 4

TEXT;
