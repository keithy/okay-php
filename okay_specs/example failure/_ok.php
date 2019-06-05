<?php

# _ok.php turns a directory of *.inc scripts into a test suite.
# doubles as the one-time setup script

global $OKAY_SUITE;
$OKAY_SUITE = __DIR__;

# first time
if (!defined('__OKAY__')) {
    require(__DIR__ . '/../_okay.php');
    return;
}

# second time

# Initialisation code - one-time setup for this directory

#
#
