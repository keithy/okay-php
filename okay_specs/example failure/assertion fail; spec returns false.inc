<?php

namespace ok {

    EXPECT("assertion failure");

    _("to look like this");

    if (version_compare(PHP_VERSION, '5.4.0') >= 0) {

        assert(false, "assert failed AS EXPECTED");
    } else {

        assert(false /* failed AS EXPECTED */); // php<=5.3
    }
}

namespace ok {

    EXPECT("specification return value");

    _("should be ignored");

    return false;
}