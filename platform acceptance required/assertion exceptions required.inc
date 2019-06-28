<?php

namespace ok {

    EXPECT("assertions ini configuration");

    _("to be enabled");

    assert(1 == ini_get('zend.assertions')   );

    _("using assert callbacks (within okay specs)");

    assert(0 == ini_get('assert.exception') );  
    assert(1 == assert_options(ASSERT_ACTIVE));
    assert(null !== assert_options(ASSERT_CALLBACK)  );  
    
}

 