<?php

namespace ok {

    EXPECT("to find needle in same directory");

    $start = __DIR__ . '/fixture/A/B/C';

    assert(lookup_and_include('needleC', $start) == "C");
}

namespace ok {

    EXPECT("to find needle via parent directory");

    assert(lookup_and_include('needleB', $start) == "B");
}