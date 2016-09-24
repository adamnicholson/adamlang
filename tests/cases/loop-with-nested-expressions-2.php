<?php
$code = <<<ADAMLANG
loop 5 {print (str (str (str (str (str :i))))) EOL}
ADAMLANG;
$output = <<<TEXT
0
1
2
3
4

TEXT;
