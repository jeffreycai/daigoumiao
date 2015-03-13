<?php

// check if already login, if yes, redirect to homepage
if (is_login()) {
  HTML::forward('');
}

// override this call if "site" module has the override controller
$override_controller = MODULESROOT . '/site/controllers/siteuser/user_login.php';
if (is_file($override_controller)) {
  require $override_controller;
  exit;
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array('title' => i18n(array(
    'en' => 'Login',
    'zh' => '登录'
))));
echo SiteUser::renderLoginForm();
$html->renderOut('core/backend/html_footer');

exit;