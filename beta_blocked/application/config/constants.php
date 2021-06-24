<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

define('ONLINE_DELAY', 1);
define('DEMO_MODE', 0);
define('SCRIPT_VERSION', "3.0");



/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Google Maps API Key
define('MAPS_API_KEY', 'google-maps-api-key-goes-here');
define('ENCRYPTION_DRIVER', 'openssl');
define('SEARCH_AGE_RANGE', '18,65');
define('SEARCH_DISTANCE_RANGE', '0,600');
define('SEARCH_HEIGHT_RANGE', '140,210');
define('MESSAGE_DATE_FORMAT', 'Y-m-d');
define('MESSAGE_TIME_FORMAT', 'H:i');
define('SITE_DATETIME_FORMAT', 'Y-m-d h:i A');
define('PROFILE_PICTURE_UPLOAD_LIMIT', 4);
define('VIP_PICTURE_UPLOAD_LIMIT', 8);
define('PRIVATE_PICTURE_UPLOAD_LIMIT', 8);
define('SHOW_UPLOAD_PROFILE_PICTURE_DIALOG_COUNT', 3);
define('USER_IS_ONLINE_CHECK_TIME', '00:59:00'); // users with 30 mins time is used find users online (HH:MM:SS Time Format )
define('USER_IS_ONLINE_CHECK_TIME_FOR_MYSQL', 'INTERVAL 59 MINUTE');
define('USER_IS_ONLINE_REAL_TIME_FOR_MYSQL', 'INTERVAL 3 MINUTE');
define('USER_MESSAGE_TYPING_CHECK_TIME_FOR_MYSQL', 'INTERVAL 5 SECOND');
define('CHAT_ACTIVATION_VALID_UPTO_MONTHS', 1);
define('AGENT_MAX_READ_RECORDS', 10);
define('DEFAULT_TIMEZONE', 'Asia/Kolkata');
define('DEFAULT_COUNTRY', 'India');
define('DEFAULT_LANGUAGE', 'english');
define('GOOGLE_MAP_API_KEY', 'AIzaSyBhibFcpcYcQES0bvP4d_0HofWwUnNCNCg');

// Oppwa payment success results, use 000.000.00 for live mode and 000.100.110 for testing mode
define('OPPWA_PAYMENT_GATEWAY', '1');
define('OPPWA_PAYMENT_SUCCESS_CODE_TEST', '000.100.110');
define('OPPWA_PAYMENT_SUCCESS_CODE_LIVE', '000.000.000');