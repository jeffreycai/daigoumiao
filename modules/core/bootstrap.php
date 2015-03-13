<?php
// define global const
define('UID_BACKEND_LOGIN_FORM', 'Backend Login Form');


// register maintenance admin page
$user = User::getInstance();
if (!is_cli() && $user->isLogin() && is_backend()) {
  
  // register admin
  Backend::registerSideNav(
  '
  <li>
    <a href="'.uri('admin/maintenance').'"><i class="fa fa-wrench"></i> '.i18n(array('en' => 'Maintenance', 'zh' => '系统维护')) . '</a>
  </li>
  '        
  );

}