<?php

# _ok.php turns a directory of *.inc scripts into a test suite.
 
global $OKAY_SUITE;
$OKAY_SUITE = __DIR__;

require_once(__DIR__.'/../_okay.php');
