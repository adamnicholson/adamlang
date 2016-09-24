<?php
$code = <<<ADAMLANG
fn "factor-of-3?" "num" {equals 0 (mod :num 3)}
fn "factor-of-5?" "num" {equals 0 (mod :num 5)}
fn "factor-of-3-and-5?" "num" {perhaps (factor-of-5? :num) {factor-of-3? :num} false}
fn "fizzbuzz" "num" {perhaps (factor-of-5? :num) "buzz" {perhaps (factor-of-3? :num) "fizz" :num}}
loop 1..9 {print (str (fizzbuzz :i)) EOL}
ADAMLANG;
$output = <<<TEXT
1
2
fizz
4
buzz
fizz
7
8
fizz

TEXT;
