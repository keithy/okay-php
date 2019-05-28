<?php

ok\expect("fixture directory to be empty");

assert(!file_exists(__DIR__ . '/fixture_to/dummy.php'));
assert(!file_exists(__DIR__ . '/fixture_to/dummy.inc'));
assert(!file_exists(__DIR__ . '/fixture_to/empty.inc'));

ok\expect("copy_all files from snapshot to populate fixture directory");

ok\copy_all(__DIR__ . '/fixture_from', __DIR__ . '/fixture_to');

assert(file_exists(__DIR__ . '/fixture_to/dummy.inc'));
assert(file_exists(__DIR__ . '/fixture_to/empty.inc'));
assert(file_exists(__DIR__ . '/fixture_to/dummy.php'));

ok\expect("delete files matching *.inc");
        
ok\delete_all_matching(__DIR__, '/fixture_to/*.inc');

ok\should("leave a *.php file ");

assert(!file_exists(__DIR__ . '/fixture_to/dummy.inc'));
assert(!file_exists(__DIR__ . '/fixture_to/empty.inc'));
assert(file_exists(__DIR__ . '/fixture_to/dummy.php'));

ok\expect("delete files matching *.php");

ok\delete_all_matching(__DIR__ , '/fixture_to/*.php');

ok\should("leave directory empty");

assert(!file_exists(__DIR__ . '/fixture_to/dummy.php'));
