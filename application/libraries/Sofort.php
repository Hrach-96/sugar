<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Facebook PHP SDK v4 for CodeIgniter 3
 *
 * Library wrapper for Facebook PHP SDK v4. Check user login status, publish to feed
 * and more with easy to user CodeIgniter syntax.
 *
 * This library requires that Facebook PHP SDK v4 is installed with composer, and that CodeIgniter
 * config is set to autoload the vendor folder. More information in the CodeIgniter user guide at
 * http://www.codeigniter.com/userguide3/general/autoloader.html?highlight=composer
 *
 * It also requires CodeIgniter session library to be correctly configured.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      Mattias Hedman
 * @license     MIT
 * @link        https://github.com/darkwhispering/facebook-sdk-v4-codeigniter
 * @version     2.0.0
 */

require_once('sofort/src/Sofort/SofortLib/AbstractWrapper.php');
require_once('sofort/src/Sofort/SofortLib/Multipay.php' );
require_once('sofort/src/Sofort/SofortLib/Sofortueberweisung.php' );


// Load all required Facebook classes
use Sofort\SofortLib;
use Sofort\SofortLib\AbstractWrapper;
use Sofort\SofortLib\Multipay;
use Sofort\SofortLib\Sofortueberweisung;
