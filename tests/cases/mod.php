<?php
$code = <<<ADAMLANG
print "6 mod 3 is " (str (mod 6 3)) EOL
print "6 " (perhaps (equals 0 (mod 6 3)) "is" "is not") " a factor of 3"
ADAMLANG;
$output = <<<TEXT
6 mod 3 is 0
6 is a factor of 3
TEXT;
