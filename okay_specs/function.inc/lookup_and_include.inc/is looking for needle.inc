<?php

$start = __DIR__ . '/fixture/A/B/C';

ok\expect("to find needle in same directory");


assert( ok\lookup_and_include('needleC', $start) == "C");

ok\expect("to find needle via parent directory");

assert( ok\lookup_and_include('needleB', $start) == "B");
 
