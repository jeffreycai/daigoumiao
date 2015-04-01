<?php

// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-vendors"></i> '.i18n(array('en' => 'Vendor', 'zh' => '商家')).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/vendor/list').'">'.i18n(array('en' => 'Vendor list', 'zh' => '商家列表')).'</a></li>
      <li><a href="'.uri('admin/vendor/create').'">'.i18n(array('en' => 'Create new vendor', 'zh' => '创建新商家')).'</a></li>
    </ul>
  </li>
  '        
  );
}