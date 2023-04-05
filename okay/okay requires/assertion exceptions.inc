<?php

namespace ok {

    // Uncomment temporarily to test that the following tests catch the problem
    // ini_set('zend.assertions', 0);

    $FAIL = 0;

    EXPECT("assertions ini configuration");

    _("to be enabled");

    // If assert is disabled we cant use assert to check!

    assert(1 == ini_get('zend.assertions')   );

    if (1 != ini_get('zend.assertions')) {
        ++$FAIL;
        printf("      ASSERTIONS NOT ENABLED CORRECTLY zend.assertions != 1\n");
    }

    _("using assert callbacks (within okay specs)");

    assert(0 == ini_get('assert.exception') );

    if (0 != ini_get('assert.exception')) {
        ++$FAIL;
        printf("      ASSERTIONS NOT ENABLED CORRECTLY assert.exception != 0\n");
    }

    assert(1 == assert_options(ASSERT_ACTIVE));

    if (1 != assert_options(ASSERT_ACTIVE)) {
        ++$FAIL;
        printf("      ASSERTIONS NOT ENABLED CORRECTLY assert_options(ASSERT_ACTIVE) != 1\n");
    }

    assert(null !== assert_options(ASSERT_CALLBACK)  );  

    if (null == assert_options(ASSERT_CALLBACK) ) {
        ++$FAIL;
        printf("      ASSERTIONS NOT ENABLED CORRECTLY assert_options(ASSERT_CALLBACK) not set\n");
    }

    if ($FAIL) {
        okay()->count_failed_assertions = okay()->count_failed_assertions + $FAIL;
    }

}

 