<?php

// customize per-installation
// This example restricts access to localhost.
// also if the webserver has set DEV_ALLOWED.

return ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") || (strpos($_SERVER['DEV_ALLOWED'], ".okay.") == false);
