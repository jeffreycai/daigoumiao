<?php
define('PRODUCT_THUMBNAIL_URL', FILE_DIR . DS . 'products');
if (!is_dir(PRODUCT_THUMBNAIL_URL)) {
  mkdir(PRODUCT_THUMBNAIL_URL);
}
// check avatar folder exist and writable
if (!is_writable(PRODUCT_THUMBNAIL_URL)) {
  die('siteuser_profile module: Avatar folder needs to be writable.');
}