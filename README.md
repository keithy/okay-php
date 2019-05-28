[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/keithy/okay-php.svg?branch=master)](https://travis-ci.org/keithy/okay-php)
[![GitHub issues](https://img.shields.io/github/issues/keithy/okay-php.svg)](https://github.com/keithy/okay-php/issues)
[![Latest Version](https://img.shields.io/github/release/keithy/okay-php.svg)](https://github.com/keithy/okay-php/releases)
[![PHP from Travis config](https://img.shields.io/travis/php-v/keithy/okay-php.svg?style=flat-square)](https://travis-ci.org/keithy/okay-php)

# OKAY 0.8 -  Keeping It Simple Specifications for PHP
 
Totally the simplest BDD/TDD framework,... in the world!
 
Design based on the original SUnit by Kent Beck
  
A result of another Cunningham-Beck innovation:
http://wiki.c2.com/?DoTheSimplestThingThatCouldPossiblyWork
  
## Documentation:
   
2. _okay.php is all of the code (<200 lines), both a command line, and a web test runner (wip)

1. Adding `_ok.php` turns a directory of `*.inc` scripts/directories into a spec/test suite.
   (Edit it manually in order to directly require the `_okay.php` file.)

3. BDD style "english" output.
    ```
    ok\expect("it to be good");
    ``` 
4. Uses PHP built in `assert`
    ```
    assert( $it == "good" , "'$it' wasn't good" );
    ```

5. Use throughout your codebase, deployment optional

   Great for adding specs/tests to a file-based "legacy" PHP system.
   (adjust your deployment to ignore/delete `_*` files, and it's gone.)
  
6. Zero dependencies

    Does not need a functioning composer/autoload. Will not clutter your cool lean codebase.
    Will not frighten your package users by loading lots of stuff, just for testing/require-dev.

7. Excellent basis for "Platform Tests" and White Screen of Death debugging

    Platform-tests run to verify that the deployment platform, PHP runtime, and Databases and
    other bits and pieces are configured and working as expected.
 
    When faced with the PHP - W.S.O.D. and no clues, a platform test/spec suite can check for common
    misconfiguration scenarios, can tell you what is working. 
 
8. Compare Runs - see only the differences

    ```
    # generate expected output
    php _okay.php | tee  .out
    # change something
    php _okay.php | diff .out -
    ```

9. Go Continuous - genius!

    ```
    watch -n3  'php _okay.php | diff .out -' 
    ```
10. Works great with travis.ci in github
 ```
 language: php
 php: [5.6,7.1]
 script: php _okay.php | diff .expected -
 ```
## Usage

1. Copy the `_okay.php` file to somewhere within your project, or to the root of your specs/tests folder.

2. Copy the `_ok.php` file to the root of any other specs/tests folder within your project.
   (edit it so that it can find _okay.php)

## Example Output
Nothing fancy

```
OKAY(0.8):/home/travis/build/keithy/okay-php
Given okay spec file returns true or false
  Expect returning true to be a pass and to look like this
    Given okay_specs function copy_all_matching can prepare fixtures
      Expect fixture directory to be empty
      Expect copy_all files from snapshot to populate fixture directory
      Expect delete files matching *.inc
        should leave a *.php file 
      Expect delete files matching *.php
        should leave directory empty
    Given okay_specs function lookup_and_include is looking for needle
      Expect to find needle in same directory
      Expect to find needle via parent directory
    Given okay_specs function lookup_and_include is looking for non existant file
      Expect it to return false
Given okay_specs example failure assertion fail, spec returns true
  Expect assertion failure
    to look like this
  FAILED(9): assert failed AS EXPECTED
  Expect specification return value
    should be ignored
Given okay_specs example failure assertion fail; spec returns false
  Expect assertion failure
    to look like this
  FAILED(9): assert failed AS EXPECTED
  Expect specification return value
    should be ignored
Ran 6 files (12 expectations) failed 2 assertions
```

#### To Do

HTML Web Runner - not quite ready.
