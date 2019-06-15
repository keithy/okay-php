<?php

// customize per-installation
return ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") || (strpos($_SERVER['DEV_ALLOWED'], ".okay.") == false);
