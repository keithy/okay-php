<?php

# _ok.php turns a directory of *.inc scripts into a test suite.
# doubles as the one-time setup script

# first time
if (require(__DIR__ . '/../_okay.php')) return;

# second time - one-time setup code for this directory

#
#
