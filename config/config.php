<?php
  define('DEV', true);
  define('DEBUG', true);

  define('BC_CLIENT_ID', 'ea56g887p2zrk8j3wwzq5ay66ogjcr5');
  define('BC_CLIENT_SECRET', 'b739cfadd4246eeda9db3d48fb6ac7f74eca2d11e0dbe3c198d3de36fc024c09');
  define('BC_ACCESS_TOKEN', '44bs4wt3za1r89fjup2c3leizioqstx');
  define('BC_STORE_HASH', '9ese1');

  define('SA_SITE_ID', 29957);
  define('SA_API_TOKEN', 'b48cad61c7');

  if (DEV) {
    define('DB_HOST', 'localhost');
    define('DB_PORT', '');
    define('DB_NAME', 'shopper-approved');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
  } else {
    define('DB_HOST', 'localhost');
    define('DB_PORT', '');
    define('DB_NAME', 'shopperapproved');
    define('DB_USER', 'sa_user');
    define('DB_PASSWORD', 'Craft78*FunctionSlate');  
  }
