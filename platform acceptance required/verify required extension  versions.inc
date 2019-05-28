<?php

ok\expect("PHP version and extensions to be loaded");

ok\writeln('PHP_VERSION: '. phpversion());
 
ok\writeln('sodium: ', (extension_loaded('sodium') ? 'yes' : 'NO'));
 
ok\writeln('pdo: '. (extension_loaded('pdo') ? 'yes' : 'NO'));
 
ok\writeln('mysqli: '. (extension_loaded('mysqli') ? 'yes' : 'NO'));

ok\writeln('mysql: '. (extension_loaded('mysql') ? 'yes' : 'NO'));
 
ok\writeln( 'memcached: '. (extension_loaded('memcached') ? 'yes' : 'NO'));
 
ok\writeln( 'xdebug: ' . (extension_loaded('xdebug') ? 'yes' : 'NO'));

