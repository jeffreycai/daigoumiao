<?php

/** this is an override of the original controller in siteuser module **/

// by default we assign the user as role AFFILIATOR
if (!is_null($user) && $user->getEmailActivated() == 0) {
  $ur = new SiteUserRole();
  $ur->setRoleId(2);
  $ur->setUserId($user->getId());
  $ur->save();
  HTML::forward('confirm');
}


$html = new HTML();



$html->renderOut('core/backend/single_form_header', array('title' => i18n(array(
          'en' => 'New user signup',
          'zh' => '新用户注册'
      ))));
echo SiteUser::renderSignupForm(null, '', array('avatar', 'active'));
$html->renderOut('core/backend/single_form_footer', array(
    'extra' => '<div  style="text-align: center;"><small class="login"><a href="'.uri('users').'">'.i18n(array('en' => 'login as exsiting user', 'zh' => '现有用户登录')).'</a></small></div>'
));


exit;