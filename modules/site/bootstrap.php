<?php
define('PRODUCT_THUMBNAIL_DIR', FILE_DIR . DS . 'products');
if (!is_dir(PRODUCT_THUMBNAIL_DIR)) {
  mkdir(PRODUCT_THUMBNAIL_DIR);
}
// check avatar folder exist and writable
if (!is_writable(PRODUCT_THUMBNAIL_DIR)) {
  die('siteuser_profile module: Avatar folder needs to be writable.');
}

$user = User::getInstance();
// register admin side nav
if (!is_cli() && $user->isLogin() && is_backend()) {
  
  // register admin
  Backend::registerSideNav(
  '
  <li>
    <a href="'.uri('admin/items/list').'"><i class="fa fa-list-alt"></i> '.i18n(array('en' => 'Item list', 'zh' => '产品列表')) . '</a>
  </li>
  '        
  );

}