<?php
$code = <<<ADAMLANG
loop 5 {print "Test: " (str (perhaps {equals 3 :i} "THREE" (str :i))) EOL}
ADAMLANG;
$output = <<<TEXT
Test: 0
Test: 1
Test: 2
Test: THREE
Test: 4

TEXT;
