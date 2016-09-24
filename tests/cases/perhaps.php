<?php
$code = <<<ADAMLANG
perhaps true {print "Value is TRUE!"} {print "Value is FALSE!"}
perhaps false {print "Value is TRUE!"} {print "Value is FALSE!"}
ADAMLANG;
$output = <<<TEXT
Value is TRUE!Value is FALSE!
TEXT;
