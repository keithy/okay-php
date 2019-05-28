<?php

echo "wiring_override_present: ", (file_exists(__SITE__ . "/WIRING_OVERRIDE.inc") ? 'yes' : 'no');

ok\expect("expectation...");

echo "wiring_override_allowed: ", (getenv('WIRING_OVERRIDE_ALLOWED') ? 'yes' : 'no');
