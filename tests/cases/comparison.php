<?php
$code = <<<ADAMLANG
print (perhaps (equals 1 2) "yes!" "nope!") EOL
print (perhaps (equals 1 1) "yes!" "nope!") EOL
print (perhaps (equals 2 1) "yes!" "nope!") EOL
print (perhaps (equals 1 1 2) "yes!" "nope!") EOL
print (perhaps (equals 1 1 1) "yes!" "nope!") EOL
ADAMLANG;
$output = <<<TEXT
nope!
yes!
nope!
nope!
yes!

TEXT;
