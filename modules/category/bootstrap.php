<?php

// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-folder-open"></i> '.i18n(array('en' => 'Category', 'zh' => '分类')).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/category/list').'">'.i18n(array('en' => 'Category list', 'zh' => '分类列表')).'</a></li>
      <li><a href="'.uri('admin/category/create').'">'.i18n(array('en' => 'Create new category', 'zh' => '创建新分类')).'</a></li>
    </ul>
  </li>
  '        
  );
}