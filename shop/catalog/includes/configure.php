<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// Define the webserver and path parameters
// * DIR_FS_* = Filesystem directories (local/physical)
// * DIR_WS_* = Webserver directories (virtual/URL)
  define('HTTP_SERVER', 'http://www.brainvoyage.com'); // eg, http://localhost - should not be empty for productive servers
  define('HTTPS_SERVER', 'https://www.brainvoyage.com'); // eg, https://localhost - should not be empty for productive servers
  define('ENABLE_SSL', true); // secure webserver for checkout procedure?
  define('HTTP_COOKIE_DOMAIN', 'www.brainvoyage.com');
  define('HTTPS_COOKIE_DOMAIN', 'www.brainvoyage.com');
  define('HTTP_COOKIE_PATH', '/shop/catalog/');
  define('HTTPS_COOKIE_PATH', '/shop/catalog/');
  define('DIR_WS_HTTP_CATALOG', '/shop/catalog/');
  define('DIR_WS_HTTPS_CATALOG', '/shop/catalog/');
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');

  define('DIR_WS_DOWNLOAD_PUBLIC', 'pub/');
  define('DIR_FS_CATALOG', '/home/content/48/7686848/html/shop/catalog/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

// define our database connection
  define('DB_SERVER', '72.167.233.102'); // eg, localhost - should not be empty for productive servers
  define('DB_SERVER_USERNAME', 'bvdatabase');
  define('DB_SERVER_PASSWORD', 'silverhair');
  define('DB_DATABASE', 'bvdatabase');
  
  //define('DB_SERVER', '64.224.17.147'); // eg, localhost - should not be empty for productive servers
  //define('DB_SERVER_USERNAME', 'bvdatabase');
  //define('DB_SERVER_PASSWORD', '$ilv3RHair');
  //define('DB_DATABASE', 'brainvoyage');
  define('USE_PCONNECT', 'false'); // use persistent connections?
  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'
// CLR 020605 defines needed for Product Option Type feature.
  define('PRODUCTS_OPTIONS_TYPE_SELECT', 0);
  define('PRODUCTS_OPTIONS_TYPE_TEXT', 1);
  define('PRODUCTS_OPTIONS_TYPE_RADIO', 2);
  define('PRODUCTS_OPTIONS_TYPE_CHECKBOX', 3);
  define('PRODUCTS_OPTIONS_TYPE_TEXTAREA', 4);
  define('TEXT_PREFIX', 'txt_');
  define('PRODUCTS_OPTIONS_VALUE_TEXT_ID', 0);  //Must match id for user defined "TEXT" value in db table TABLE_PRODUCTS_OPTIONS_VALUES
define('DIR_FS_CACHE_XSELL', 'cache/');
?>
