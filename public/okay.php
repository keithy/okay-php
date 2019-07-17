<?php

# Public web_runner, copy to somewhere that is served

// Webrunner sets the root of the test SUITE
global $OKAY_SUITE;
$OKAY_SUITE = __DIR__.'/../../okay';

// Webrunner needs to find _okay.php, normally ../vendor/okay/okay
$path = '/../../vendor/okay/okay/';

require(__DIR__ . $path. '_okay.php');
