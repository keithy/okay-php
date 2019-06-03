<?php

namespace ok {

    EXPECT("it to return false");

    $start = __DIR__ . '/fixture/A/B/C';

    assert(false == lookup_and_include('no_way_this_exists', $start));
}