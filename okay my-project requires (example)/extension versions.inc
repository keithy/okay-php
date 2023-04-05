<?php

namespace ok {
    
    EXPECT("PHP version and extensions to be loaded");

    _('PHP_VERSION: ' . phpversion());

    _('sodium: ', (extension_loaded('sodium') ? 'yes' : 'NO'));

    _('pdo: ' . (extension_loaded('pdo') ? 'yes' : 'NO'));

    _('mysqli: ' . (extension_loaded('mysqli') ? 'yes' : 'NO'));

    _('mysql: ' . (extension_loaded('mysql') ? 'yes' : 'NO'));

    _('memcached: ' . (extension_loaded('memcached') ? 'yes' : 'NO'));

    _('xdebug: ' . (extension_loaded('xdebug') ? 'yes' : 'NO'));
}
