<?php
define('PRODUCT_THUMBNAIL_DIR', FILE_DIR . DS . 'products');
if (!is_dir(PRODUCT_THUMBNAIL_DIR)) {
  mkdir(PRODUCT_THUMBNAIL_DIR);
}
// check avatar folder exist and writable
if (!is_writable(PRODUCT_THUMBNAIL_DIR)) {
  die('siteuser_profile module: Avatar folder needs to be writable.');
}