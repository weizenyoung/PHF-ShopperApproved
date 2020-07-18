<?php
  define('ROOT_DIR', dirname(dirname(__FILE__)));
  define('APP_DIR', ROOT_DIR . '/app');
  define('CONFIG_DIR', ROOT_DIR . '/config');
  define('PUBLIC_DIR', ROOT_DIR . '/public');
  define('STORAGE_DIR', ROOT_DIR . '/storage');
  define('LOG_DIR', STORAGE_DIR . '/log');
 
  require_once(APP_DIR . '/constants.php');
  require_once(CONFIG_DIR . '/config.php');
  require_once(APP_DIR . '/utils.php');
  require_once(APP_DIR . '/Database.php');
  require_once(APP_DIR . '/BigCommerce.php');
  require_once(APP_DIR . '/ShopperApproved.php');
  
  if (DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  }
  