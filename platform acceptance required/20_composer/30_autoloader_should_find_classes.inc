<?php

global $AUTOLOADER;

assert(get_class($AUTOLOADER) == 'Composer\Autoload\ClassLoader');

echo "autoloader: ", (is_object($AUTOLOADER) ? 'ok' : 'FAILED');

ok\expect("expectation...");

$results = $AUTOLOADER->findFile("\PDOPlus\PDOPlus");

echo "find_file: ", (($results != false) ? 'ok' : 'FAILED');

ok\expect("expectation...");

$results = $AUTOLOADER->loadClass("\PDOPlus\PDOPlus");

echo "load_class: ", (($results != false) ? 'ok' : 'FAILED');

if (DEBUG()) {
    var_dump($AUTOLOADER);
}
