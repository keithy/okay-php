<?php

$start = __DIR__ . '/fixture/A/B/C';

ok\expect("it to return false");

assert( false == ok\lookup_and_include('no_way_this_exists', $start) );
