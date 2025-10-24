<?php

namespace Social;

if (version_compare(PHP_VERSION, '8.2.0') <= 0) {
    die('Social is not compatible with your PHP version. Social supports PHP 8.2 or newer.');
}

if (!file_exists(BLUFF_VENDOR_PATH . '/autoload.php')) {
    die('The required Composer packages are missing. Please read the setup instructions in the README file.');
}

if (!file_exists(BLUFF_PRIVATE_PATH . '/config/config.php')) {
    die('The configuration file could not be found. Please read the setup instructions in the README file.');
}

// TODO: add check for BluffingoCore -chaziz 07/19/2025

$config = include_once(BLUFF_PRIVATE_PATH . '/config/config.php');
require_once(BLUFF_VENDOR_PATH . '/autoload.php');

use Social\VersionNumber;

ini_set('session.gc_maxlifetime', 86400);

// please use apache/nginx for production stuff.
define('BLUFF_PHP_BUILTINSERVER', php_sapi_name() === 'cli-server');
define('BLUFF_CLI', php_sapi_name() === 'cli');

if (!BLUFF_CLI) {
    $blacklisted_user_agents = [
        '/python-requests/i',
        '/curl/i',
    ];

    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    foreach ($blacklisted_user_agents as $pattern) {
        if (preg_match($pattern, $user_agent)) {
            http_response_code(403);
            exit;
        }
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_name("sb_session");

        $is_secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

        session_set_cookie_params([
            'lifetime' => 86400,
            'path' => '/',
            'secure' => $is_secure,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        session_start([
            "cookie_lifetime" => 86400,
            "gc_maxlifetime" => 86400,
        ]);
    }
}

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);

    if (file_exists(BLUFF_PRIVATE_PATH . "/class/$class_name.php")) {
        require BLUFF_PRIVATE_PATH . "/class/$class_name.php";
    }
});

set_exception_handler(function ($exception) {
    $version_number = new VersionNumber(); // kinda ugly imo

    if (BLUFF_CLI) {
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
        http_response_code(500);

        $errorMsg = sprintf(
            '<b>Error:</b> %s<br>'
                . '<b>Code:</b> %s<br>'
                . '<b>File:</b> %s<br>'
                . '<b>Line:</b> %s<br>'
                . '<b>Version:</b> %s<br>'
                . '<b>Stack Trace:</b><pre style="white-space:pre-line;">%s</pre>',
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine(),
            $version_number->getVersionString(),
            $exception->getTraceAsString()
        );

        $githubNewIssueUrl = sprintf(
            'https://github.com/bluffingo/social/issues/new?title=%s&labels=bug&body=%s',
            urlencode('Error: ' . $exception->getMessage()),
            urlencode(
                "**Error**: " . $exception->getMessage() . "\n\n" .
                    "**Code**: " . $exception->getCode() . "\n" .
                    "**File**: " . $exception->getFile() . "\n" .
                    "**Line**: " . $exception->getLine() . "\n" .
                    "**URL**: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n" .
                    "**Version**: " . $version_number->getVersionString() . "\n\n" .
                    "**Stack Trace**:\n```\n" . $exception->getTraceAsString() . "\n```"
            )
        );

        echo sprintf(
            "<h1>An error has occurred</h1>" .
                "<div style='padding: 1em; border: 1px solid red;'>" .
                "%s" .
                "<p>Please report this error on GitHub: <a href='%s' target='_blank'>Report</a></p>" .
                "</div>",
            $errorMsg,
            $githubNewIssueUrl,
        );
        die();
    }
});

// now initialize the social class
$social = new Social($config);
$database = $social->getDatabaseClass();

if (!BLUFF_CLI) {
    $version_number = new VersionNumber(); // kinda ugly imo
    header('X-Powered-By: Social ' . $version_number->getVersionString());

    $twig = new Templating($social);
}
