[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build Status](https://travis-ci.com/keithy/okay-php.svg?branch=master)](https://travis-ci.com/keithy/okay-php)
[![GitHub issues](https://img.shields.io/github/issues/keithy/okay-php.svg)](https://github.com/keithy/okay-php/issues)
[![Latest Version](https://img.shields.io/github/release/keithy/okay-php.svg)](https://github.com/keithy/okay-php/releases)
[![PHP from Travis config](https://img.shields.io/travis/php-v/keithy/okay-php.svg)](https://travis-ci.org/keithy/okay-php)

# OKAY 0.9 -  Keeping It Simple Specifications for PHP
 
Totally the simplest BDD/TDD framework,... in the world!
 
Design based on the original SUnit by Kent Beck
  
A result of another Cunningham-Beck innovation:
http://wiki.c2.com/?DoTheSimplestThingThatCouldPossiblyWork
  
## Documentation:
   
1. `_okay.php` is all of the code (<300 lines), both a command line, and a web test runner (wip)

2. Adding `_ok.php` turns a directory of `*.inc` scripts/directories into a spec/test suite.
   (Edit it manually in order to directly require the `_okay.php` file.) 

 `_ok.php` also provides one-time run_setup code for specs/tests/okays in that directory.

3. BDD style "english" output.
    ```
    EXPECT("it to be good");
    ``` 
4. Uses PHP built in `assert`
    ```
    _("it's going to be good");
    assert( $it == "good" , "'$it' wasn't good" );
    ```

5. Use throughout your codebase, deployment optional

   Great for adding specs/tests to a file-based "legacy" PHP system.
   (adjust your deployment to ignore/delete `_*` files, and it's gone.)
  
6. Zero dependencies

    Does not need a functioning composer/autoload. Will not clutter your cool, lean code-base.
    Will not frighten your package users by loading lots of stuff, just for testing/require-dev.

7. Excellent basis for "Platform Tests" and White Screen of Death debugging

    Platform-tests run to verify that the deployment platform, PHP runtime, and Databases and
    other bits and pieces are configured and working as expected.
 
    When faced with the PHP - W.S.O.D. and no clues, a platform test/spec suite can check for common
    misconfiguration scenarios and tell you what is working. 
 
8. Compare Runs - see only the differences

    ```
    # generate expected output
    php _okay.php | tee  .out
    # change something
    php _okay.php | diff -U5 .out -
    ```

9. Go Continuous - genius!

    ```
    watch -n3  'php _okay.php | diff -U5 .out -' 
    ```
10. Works great with travis.ci in github
 ```
 language: php
 php: [5.6,7.1]
 script: php okay/_okay.php -I
 ```

## Usage Composer
```
composer require --dev okay/okay 
```
## Usage Standalone

1. Copy the `_okay.php` file to somewhere within your project, or to the root of your specs/tests/okay folder.

2. Copy the `_ok.php` file to the root of any other specs/tests folder within your project.
   (edit it so that it can find _okay.php)

## Example Output
Nothing fancy

```
OKAY(0.8):/home/travis/build/keithy/okay-php

Given okay spec file returns true or false
 1) Expect returning true to be a pass and to look like this

Given okay_specs function copy_all_matching can prepare fixtures
 2) Expect fixture directory to be empty
 3) Expect copy_all files from snapshot to populate fixture directory
 4) Expect delete files matching *.inc
      should leave a *.php file 
 5) Expect delete files matching *.php
      should leave directory empty

Given okay_specs function lookup_and_include is looking for needle
 6) Expect to find needle in same directory
 7) Expect to find needle via parent directory

Given okay_specs function lookup_and_include is looking for non existent file
 8) Expect it to return false

Given okay_specs example failure assertion fail, spec returns true
 9) Expect assertion failure
      to look like this
FAILED(14): assert failed AS EXPECTED
10) Expect specification return value
      should be ignored

Given okay_specs example failure assertion fail; spec returns false
11) Expect assertion failure
      to look like this
FAILED(14): assert failed AS EXPECTED
12) Expect specification return value
      should be ignored
Ran 6 files (12 expectations) failed 2 assertions
```

#### To Do

Beautify the runners.
Make based runner - runs tests in independent php processes!

