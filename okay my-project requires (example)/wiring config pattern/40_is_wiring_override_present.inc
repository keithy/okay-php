<?php

// WIRING is our pattern for dynamic switching of config  
// normally it is set by the reverse-proxy but there is
// an option for a manual override (i.e. when running locally) 
// the reverse-proxy can disable this to prevent accidentally
// serving while in debug mode. 

echo "wiring_override_present: ", (file_exists(__SITE__ . "/WIRING_OVERRIDE.inc") ? 'yes' : 'no');

ok\expect("expectation...");

echo "wiring_override_allowed: ", (getenv('WIRING_OVERRIDE_ALLOWED') ? 'yes' : 'no');
