<?php

// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-brands"></i> '.i18n(array('en' => 'Brand', 'zh' => '品牌')).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/brand/list').'">'.i18n(array('en' => 'Brand list', 'zh' => '品牌列表')).'</a></li>
      <li><a href="'.uri('admin/brand/create').'">'.i18n(array('en' => 'Create new brand', 'zh' => '创建新品牌')).'</a></li>
    </ul>
  </li>
  '        
  );
}