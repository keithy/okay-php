<?php

namespace ok;

/*
 *   # OKAY -  Keeping It Simple Specifications for PHP!
 * 
 * Totally the simplest BDD/TDD framework,... in the world!
 * 
 * https://github.com/keithy/okay-php
 * 
 */

// Update minor version number on every commit
$OKAY_VERSION = '0.9.19';

// The enclosure of the code within the 'else' clause of this conditional ensures
// that we do not get function re-definition errors. (i.e. dont be tempted to remove it.)
if (defined('__OKAY__')) return false;
else {
    global $trace_file;

    define('__OKAY__', __FILE__);

    // Our magic constant to point to the project root. (assumes we are in /vendor/okay/okay)
    if (!defined('__PROJECT__')) define("__PROJECT__", dirname(dirname(dirname(__DIR__))));

    function log_errors($on, $options = E_ALL)
    {
        ini_set('xdebug.collect_params' , 4);
        ini_set('log_errors', ($on ? 1 : 0));
        ini_set('display_errors', ($on ? 1 : 0));
        ini_set('display_startup_errors', ($on ? 1 : 0));
        error_reporting($options);
        // if (extension_loaded('xdebug')) xdebug_disable(); // orange not to your taste
    }
    log_errors(true, E_ALL);

    //utility
    function include_if_present($file)
    {
        if (file_exists($file)) {
            return include($file);
        }
        return false;
    }
    // Local user/codebase can override settings
    include_if_present(__PROJECT__ . '/config/okay.inc');

    // But not these settings
    assert_options(ASSERT_WARNING, 0);
    ini_set('assert.exception', 1);

    // SetUp the runners input/output
    if (php_sapi_name() == 'cli') { // cli runner
        // Input: find a value for $OKAY_SUITE - the top level directory of this run.
        if (isset($OKAY_SUITE)) $OKAY_SUITE = realpath($OKAY_SUITE);
        else { // find the calling file's directory
            $backtrace = debug_backtrace();
            $OKAY_SUITE = (empty($backtrace)) ? __DIR__ : dirname($backtrace[0]['file']);
        }

        if (false !== $pos = array_search('-T', $_SERVER['argv']))
                $trace_file = $_SERVER['argv'][$pos + 1];

        // Output
        if (!defined('BR')) define('BR', PHP_EOL);
        if (!defined('OKAY_OUTPUT')) define('OKAY_OUTPUT', 'text/plain');
    } else { // web runner
        /* Gateway
         * For web runner security we defer to an externally supplied file - please provide your own!
         */
        if (!include($_SERVER['DOCUMENT_ROOT'] . '/../config/okay_gateway.inc'))
                die("Local security gateway is not installed");

        $trace_file = filter_input(INPUT_GET, 'trace', FILTER_SANITIZE_STRING);

        // Input
        if (isset($_GET['ok'])) $OKAY_SUITE = realpath(__PROJECT__ . '/' . $_GET['ok']);
        if (0 !== strpos($OKAY_SUITE, __PROJECT__)) die('Invalid Path');

        // Output: respond in plaintext for now.
        if (!defined('OKAY_OUTPUT')) define('OKAY_OUTPUT', 'text/plain');
        if (!defined('BR')) define('BR', PHP_EOL);
        // if (!defined('BR')) define('BR', '<BR>');

        header("Content-Type: " . OKAY_OUTPUT);
        ini_set('html_errors', 0);
    }

    // ok\DEBUG() && ok\printf("Debug only Output".BR);
    function DEBUG()
    {
        return in_array('-D', $_SERVER['argv']) || filter_input(INPUT_GET, 'debug', FILTER_VALIDATE_BOOLEAN);
    }
    
    // xdebug trace support - on - trace('/tmp/trace') & - off - trace(false);
    function trace($file = false)
    {
        if (!$file) return xdebug_stop_trace();
        xdebug_start_trace($file, XDEBUG_TRACE_APPEND);     
    }
    
    // useful for wiping out file fixtures in a directory
    function delete_all_matching($in, $match = '*')
    {
        assert($in !== ''); // more guards needed?
        assert($in !== '/');
        array_map('unlink', glob("{$in}/{$match}"));
    }

    // useful for repopulating file fixtures into a directory
    function copy_all($from, $to, $match = '*')
    {
        is_dir($to) ?: mkdir($to); // ensure existence
        foreach (glob("{$from}/{$match}") as $path) {
            copy($path, $to . '/' . basename($path));
        }
    }

    // A templating framework in a single function!
    function lookup_and_include($name, $dir, $includes = '_includes')
    {
        //**/ echo("lookup_and_include($name, $dir, $includes = '_includes')\n");
        $target = "{$dir}/{$includes}/{$name}.inc";
        if (file_exists($target)) {
            return include $target;
        } else {
            if ($dir != __DIR__ && $dir != "/" && !empty($dir)) {
                return lookup_and_include($name, dirname($dir), $includes);
            }
        }
        return false;
    }

    function okay($runner = null)
    {
        static $okay;
        if (null !== $runner) $okay = $runner;
        return $okay;
    }

    // vocabulary
    function _()
    {
        $msg = implode(' ', func_get_args());
        printf(okay()->indent() . "      {$msg}" . BR);
        return okay();
    }

    function __()
    {
        $msg = implode(' ', func_get_args());
        printf(okay()->indent() . "%2d) " . $msg . BR, ++okay()->count_expectations);
        return okay();
    }

    function given($path)
    {
        global $OKAY_SUITE;
        $given = substr($path, strlen($OKAY_SUITE));
        $given = preg_replace(array('|/\d+\.|', '|/|', '|/_|', '|\.inc|', '|\.php|', '|\.ok|'), array(' ', ' ', ' ', '', '', ''), $given);
        printf(BR . "<div class='test'><em>%sGiven{$given}</em><br><div class = 'output'>" . BR, okay()->indent());
    }

    // $okay = ok\expect("expectation...")
    function EXPECT()
    {
        $args = func_get_args();
        array_unshift($args, "Expect");
        return call_user_func_array("ok\__", $args);
    }

    function Should($message)
    {
        return _("should", $message);
    }
    /*
     * If code under test may have an endless loop, this utility comes in handy
     * ok\die_after(5);
     */

    function die_after($over = 99)
    {//calls
        static $the_edge = 0;
        if ($over < $the_edge++) die;
    }

    function isPlain()
    {
        return OKAY_OUTPUT == 'text/plain';
    }

    // function printf($format, ...$args) { // php>=5.6
    // \printf(isPlain() ? strip_tags($format) : $format, ... $args); }

    function printf($format)
    { // php<5.6
        $args = func_get_args();
        $args[0] = isPlain() ? strip_tags($format) : $format;
        call_user_func_array('\printf', $args);
    }

    function asserts($on)
    {
        if (version_compare(PHP_VERSION, '5.4.0') < 0) {
            assert_options(ASSERT_WARNING, $on);
        } else {
            if ($on) {
                ini_set('assert.exception', 0);
                assert_options(ASSERT_CALLBACK, array(okay(), 'on_assertion_failure'));
            } else {
                ini_set('assert.exception', 1);
                assert_options(ASSERT_CALLBACK, "");
            }
        }
    }

    // HT https://stackoverflow.com/users/418819/steve
    function getExceptionTraceAsString($exception, $excludeN)
    {
        $rtn = "";
        $count = 0;
        $frames = $exception->getTrace();
        array_splice($frames, count($frames) - $excludeN, $excludeN);
        foreach ($frames as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = array();
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }
                $args = join(", ", $args);
            }
            $rtn .= sprintf("#%s %s(%s): %s(%s)\n",
                    $count,
                    (isset($frame['file']) ? $frame['file'] : ''),
                    (isset($frame['line']) ? $frame['file'] : ''),
                    (isset($frame['function']) ? $frame['function'] : ''),
                    $args);
            $count++;
        }
        return $rtn;
    }

    class Okay
    {
        const glob = '/{*.inc,*.ok,*/_ok.php}';

        public $dir;
        public $count_files;
        public $count_expectations;
        public $count_failed_assertions = 0;
        public $previous_error_handler;
        public $previous_exception_handler;
        public $indent = 0;

        static function initializeRequested()
        {
            return in_array('-I', $_SERVER['argv']) || (isset($_GET['INIT']));
        }

        function indent($n = 0)
        {
            static $i;
            return str_repeat(' ', ($i = $i + $n));
        }

        function perform($dir, $method)
        {
            $file = $dir . "/{$method}";
            if (file_exists($file)) {
                DEBUG() && printf("<div class='{$method}'>performing: $file</div>" . BR);

                include($file);
            }
        }

        function test($path)
        {
            $this->assertion_fail_count = 0;

            $result = null; // if error occurrs

            given($path);

            $start = microtime(true);

            $result = $this->protect(array($this, "performTest"), $path);

            if ($this->count_failed_assertions > 0 && $result == true) {
                $result = false;
            }

            $ms = 1000 * (microtime(true) - $start);

            return $ms;
        }

        function performTest($path)
        {
            global $okaying, $trace_file;

            $this->count_files++;

            //$this->indent(+2);
            $trace_file && trace($trace_file);
            $okaying = true;

            $result = include($path);

            $okaying = false;
            $trace_file && trace(false);
            //$this->indent(-2);

            return $result;
        }

        // function protect($callable, ...$args) { // php>=5.6
        function protect($callable)
        {
            DEBUG() && printf("PROTECT\n");
            // php<5.6
            if (version_compare(PHP_VERSION, '5.4.0') < 0) {
                $this->previous_error_handler = set_error_handler(array($this, "error_handler"), E_WARNING);
            } else assert_options(ASSERT_WARNING, 0);

            //$this->previous_error_handler = set_error_handler(array($this, "error_handler"), E_WARNING);
            $this->previous_exception_handler = set_exception_handler(array($this, "exception_handler"));

            asserts(true);

            $result = call_user_func_array($callable, array_slice(func_get_args(), 1)); // php<5.6
 
            asserts(false);

            restore_exception_handler();
            restore_error_handler();

            DEBUG() && printf("PROTECTED\n");

            return $result;
        }

        function run($dir)
        {
            okay($this);
            if (static::initializeRequested()) $this->perform($dir, '_initialize.php');

            printf("<div class = 'suite'>");

            $this->perform($dir, '_ok.php');

            foreach (glob($dir . Okay::glob, GLOB_BRACE) as $path) {

                $this->perform($dir, '_setup.php');

                if (substr($path, -3) == 'php') $this->run(dirname($path));
                else if (is_dir($path)) {
                    //$this->indent(+2);
                    $this->run($path);
                    //$this->indent(-2);
                } else $this->test($path);

                $this->perform($dir, '_teardown.php');
            }

            $this->perform($dir, '_ok_teardown.php');

            printf("</div>");

            return $this;
        }

        //// We catch warnings - compatible with php5.3+
        function error_handler($level, $msg, $file, $line)
        {
            if ($level == 2 && (substr($msg, 0, 8) == 'assert()')) { // Handling Warning - php<5.4
                if (version_compare(PHP_VERSION, '5.4.0') < 0) {
                    ++$this->count_failed_assertions;
                    $msg = substr($msg, 10, strlen($msg) - 10);
                    printf("<em style = 'assertion-failed'>%s   FAILED(%s):</em> %s" . BR, $this->indent(), $line, $msg);
                }
            }

            if ($this->previous_error_handler)
                    call_user_func($this->previous_error_handler, $level, $msg, $file, $line);
        }

        function exception_handler($ex)
        {
            if ($this->previous_exception_handler == null) {

                //print_r($ex->getTraceAsString());
                printf(BR);
                printf("ERROR: " . $ex->getMessage() . BR);
                printf("IN:    " . $ex->getFile());
                printf(" (line %d)" . BR, $ex->getLine());
                printf(BR);
                printf(getExceptionTraceAsString($ex, 9));

                return null;
            }
            return $this->previous_exception_handler($ex);
        }

        function on_assertion_failure($file, $line, $code, $msg)
        {
            if (version_compare(PHP_VERSION, '5.4.0') >= 0) { // Handling Callback php>=5.4
                ++$this->count_failed_assertions;
                printf("<em style = 'assertion-failed'>%2d} %sFAILED(%s):</em> %s" . BR, $this->count_expectations, $this->indent(), $line, $msg);
            }
        }
    }

    // Output

    $title = "OKAY($OKAY_VERSION):" . $OKAY_SUITE;

    if (isPlain()) printf("$title" . BR);
    else lookup_and_include('header_okay', $OKAY_SUITE);

    $okay = new Okay();
    $okay->run($OKAY_SUITE);

    $count_files = $okay->count_files;
    $count_expectations = $okay->count_expectations;
    $count_failed_assertions = $okay->count_failed_assertions;

    $failedMsg = ($count_failed_assertions > 0) ? "failed {$count_failed_assertions} assertions" : "OK";

    if (isPlain())
            printf("Ran %d files (%d expectations) %s" . BR, $count_files, $count_expectations, $failedMsg);
    else lookup_and_include('footer_okay', $OKAY_SUITE);

    return true;
}