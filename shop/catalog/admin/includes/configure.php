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
  define('HTTP_CATALOG_SERVER', 'https://www.brainvoyage.com');
  define('HTTPS_CATALOG_SERVER', 'https://www.brainvoyage.com');
  define('ENABLE_SSL_CATALOG', 'true'); // secure webserver for catalog module
  define('DIR_FS_DOCUMENT_ROOT', '/home/content/48/7686848/html/shop/catalog/'); // where the pages are located on the server
  define('DIR_WS_ADMIN', '/shop/catalog/admin/'); // absolute path required
  define('DIR_FS_ADMIN', '/home/content/48/7686848/html/shop/catalog/admin/'); // absolute pate required
  define('DIR_WS_CATALOG', '/shop/catalog/'); // absolute path required
  define('DIR_FS_CATALOG', '/home/content/48/7686848/html/shop/catalog/'); // absolute path required
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG . 'images/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_CATALOG_LANGUAGES', DIR_WS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');
  define('DIR_FS_CACHE_XSELL', '../cache/');

// define our database connection
  
  define('DB_SERVER', '72.167.233.102'); // eg, localhost - should not be empty for productive servers
  define('DB_SERVER_USERNAME', 'bvdatabase');
  define('DB_SERVER_PASSWORD', 'silverhair');
  define('DB_DATABASE', 'bvdatabase');
  
  //define('DB_SERVER', '64.224.17.147'); // eg, localhost - should not be empty for productive servers
  //define('DB_SERVER_USERNAME', 'bvdatabase');
  //define('DB_SERVER_PASSWORD', '$ilv3RHair');
  //define('DB_DATABASE', 'brainvoyage');
  define('USE_PCONNECT', 'false'); // use persisstent connections?
  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'
?>
