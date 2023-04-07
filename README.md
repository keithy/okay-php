[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Tests Status](https://github.com/keithy/okay-php/actions/workflows/php.yml/badge.svg)](https://github.com/keithy/okay-php/actions)
[![GitHub issues](https://img.shields.io/github/issues/keithy/okay-php.svg)](https://github.com/keithy/okay-php/issues)
[![Awesome](https://img.shields.io/badge/awesome%3F-yes!-brightgreen.svg)](https://packagist.org/packages/okay/okay)
[![Latest Version](https://img.shields.io/github/release/keithy/okay-php.svg)](https://github.com/keithy/okay-php/releases)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/okay/okay.svg?maxAge=3600)](https://packagist.org/packages/okay/okay)
[![Tested on PHP 5.3 to 8.2](https://img.shields.io/badge/tested%20on-PHP%205.3%20|%205.4%20|%205.5%20|%205.6%20|%207.1%20|%207.4%20|%208.1%20|%208.2%20-brightgreen.svg?maxAge=2419200)](https://github.com/keithy/okay-php/actions)


# OKAY 1.0 -  Keeping It Simple Specifications for PHP

Totally the simplest BDD/TDD framework,... in the world!
 
Design based on the original SUnit by Kent Beck
  
A result of another Cunningham-Beck innovation:
http://wiki.c2.com/?DoTheSimplestThingThatCouldPossiblyWork

## Example Test/Spec/Okays

* Tests - TDD
* Specs - BDD vocabulary
* Okays - Our name for platform tests
```
namespace ok {

    EXPECT("assertions ini configuration");

    _("to be enabled");
    
    assert(1 == ini_get('zend.assertions'));
    assert(0 == ini_get('assert.exception'));

}
``` 
## Documentation:
   
1. `_okay.php` is all of the code (<320 lines), both a command line and web test-runner

2. Adding `_ok.php` to a directory of `*.inc` scripts/directories turns them
    into a spec/test suite.
    (edit it to have the correct path to invoke `_okay.php`)

    Each `_ok.php` can be modified to provide any one-time run_setup code for specs defined in that directory.

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

    Does not need a functioning composer/autoload, will not clutter a cool, lean code-base.
    Great for testing smaller bits and pieces (see .travis.yml for the non-trivial self-test example)
 
7. Excellent basis for "Platform Tests", "healthz" style checks, and White Screen of Death debugging

    Platform-tests run to verify that the deployment platform, PHP runtime, and Databases and
    other bits and pieces are configured and working as expected.
 
    When faced with the PHP - W.S.O.D. and no clues, a platform test/spec suite can check for common
    miss-configuration scenarios and tell you what is working. 
 
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

10. Works great with github actions

 ```
 jobs:
  build:
    runs-on: ubuntu-latest
    - name: Run okay test suite
      run: php _okay.php
 ```

11. Works great with travis.ci 
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
   (edit it to have the correct path to invoke `_okay.php`)

## Web Runner

Copy `public/okay.php`to somewhere on your site, and copy `config/gateway_okay.inc`
(edit it to have the correct path to invoke `_okay.php`)

## Example Output
Nothing fancy

```
OKAY(VERSION 1.0.2):/home/travis/build/keithy/okay-php

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

