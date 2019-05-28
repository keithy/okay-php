<?php

ok\expect("assertion failure");

ok\to("look like this");

if (version_compare(PHP_VERSION, '5.4.0') >= 0) {

    assert(false, "assert failed AS EXPECTED");
    
} else {
    
    assert(false /* failed AS EXPECTED */); // php<=5.3

    
}

ok\expect("specification return value");

ok\should("be ignored");

return false;