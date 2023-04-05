<?php

namespace ok {
    EXPECT("fixture directory to be empty");

    assert(!file_exists(__DIR__ . '/fixture_to/dummy.php'));
    assert(!file_exists(__DIR__ . '/fixture_to/dummy.inc'));
    assert(!file_exists(__DIR__ . '/fixture_to/empty.inc'));
}

namespace ok {

    EXPECT("copy_all files from snapshot to populate fixture directory");

    copy_all(__DIR__ . '/fixture_from', __DIR__ . '/fixture_to');

    assert(file_exists(__DIR__ . '/fixture_to/dummy.inc'));
    assert(file_exists(__DIR__ . '/fixture_to/empty.inc'));
    assert(file_exists(__DIR__ . '/fixture_to/dummy.php'));
}

namespace ok {

    EXPECT("delete files matching *.inc");

    delete_all_matching(__DIR__, '/fixture_to/*.inc');

    _("should leave a *.php file ");

    assert(!file_exists(__DIR__ . '/fixture_to/dummy.inc'));
    assert(!file_exists(__DIR__ . '/fixture_to/empty.inc'));
    assert(file_exists(__DIR__ . '/fixture_to/dummy.php'));
}

namespace ok {
    
    EXPECT("delete files matching *.php");

    delete_all_matching(__DIR__, '/fixture_to/*.php');

    _("should leave directory empty");

    assert(!file_exists(__DIR__ . '/fixture_to/dummy.php'));
}