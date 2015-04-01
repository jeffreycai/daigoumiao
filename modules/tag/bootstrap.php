<?php

// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-tags"></i> '.i18n(array('en' => 'Tag', 'zh' => '标签')).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/tag/list').'">'.i18n(array('en' => 'Tag list', 'zh' => '标签列表')).'</a></li>
      <li><a href="'.uri('admin/tag/create').'">'.i18n(array('en' => 'Create new tag', 'zh' => '创建新标签')).'</a></li>
    </ul>
  </li>
  '        
  );
}