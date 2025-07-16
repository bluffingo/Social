<?php

namespace Social;

define("SOCIAL_ROOT_PATH", dirname(__DIR__));
define("SOCIAL_DYNAMIC_PATH", SOCIAL_ROOT_PATH . '/dynamic');
define("SOCIAL_PUBLIC_PATH", SOCIAL_ROOT_PATH . '/public'); // we need this for SquareBracketTwigExtension
define("SOCIAL_PRIVATE_PATH", SOCIAL_ROOT_PATH . '/private');
define("SOCIAL_VENDOR_PATH", SOCIAL_ROOT_PATH . '/vendor');
define("SOCIAL_GIT_PATH", SOCIAL_ROOT_PATH . '/.git'); // ONLY FOR makeVersionString() IN SquareBracket CLASS.

define("SOCIAL_CLI", false);

if (version_compare(PHP_VERSION, '8.2.0') <= 0) {
    die('Social is not compatible with your PHP version. Social supports PHP 8.2 or newer.');
}

/*
if (!file_exists(SOCIAL_VENDOR_PATH . '/autoload.php')) {
    die('The required Composer packages are missing. Please read the setup instructions in the README file.');
}

if (!file_exists(SOCIAL_PRIVATE_PATH . '/config/config.php')) {
    die('The configuration file could not be found. Please read the setup instructions in the README file.');
}
*/

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);

    if (file_exists(SOCIAL_PRIVATE_PATH . "/class/$class_name.php")) {
        require SOCIAL_PRIVATE_PATH . "/class/$class_name.php";
    }
});

use Social\VersionNumber;

set_exception_handler(function ($exception) {
    // kinda ugly imo
    $version_number = new VersionNumber();

    if (SOCIAL_CLI) {
        $errorMsg = sprintf(
            "Error: %s" . PHP_EOL .
                "Code: %s" . PHP_EOL .
                "File: %s" . PHP_EOL .
                "Line: %s" . PHP_EOL .
                "Version: %s" . PHP_EOL .
                "Stack Trace:" . PHP_EOL . "%s" . PHP_EOL,
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine(),
            $version_number->getVersionString(),
            $exception->getTraceAsString()
        );

        echo "An error has occurred:" . PHP_EOL;
        echo $errorMsg;
        die(1);
    } else {
        $errorMsg = sprintf(
            '<b>Error:</b> %s<br>'
                . '<b>Code:</b> %s<br>'
                . '<b>File:</b> %s<br>'
                . '<b>Line:</b> %s<br>'
                . '<b>Version:</b> %s<br>'
                . '<b>Stack Trace:</b><pre>%s</pre>',
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine(),
            $version_number->getVersionString(),
            $exception->getTraceAsString()
        );

        echo sprintf(
            "<h1>An error has occurred</h1>" .
                "<div style='padding: 1em; border: 1px solid red;'>" .
                "<pre>%s</pre>" .
                "</div>",
            $errorMsg,
        );
        die();
    }
});
