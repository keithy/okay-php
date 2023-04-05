<?php

// WIRING is our pattern for dynamic switching of config
// The wiring entry point sets __SITE__ so we check this

global $WIRING;

assert(__SITE__ == $_SERVER['DOCUMENT_ROOT']);
assert($WIRING == "none");

echo "entry_point: ", ((__SITE__ == $_SERVER['DOCUMENT_ROOT']) ? 'ok' : 'FAILED');

ok\expect("expectation...");

echo "test_wiring: ", $WIRING;

