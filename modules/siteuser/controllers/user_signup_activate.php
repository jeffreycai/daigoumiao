<?php
$uid = isset($vars[1]) ? $vars[1] : null;
$salt = isset($vars[2]) ? $vars[2] : null;

// validation
if (is_null($uid) || is_null($salt)) {
  HTML::forward('core/404');
}
$user = SiteUser::findById($uid);
if (is_null($user) || $user->getSalt() != $salt) {
  HTML::forward('core/404');
}

// mail activate the user
$activated = $user->getEmailActivated();
if ($activated == 1) {
  Message::register(new Message(Message::INFO, i18n(array(
      'en' => 'You\'ve already activated your acount. No need to do it again.',
      'zh' => '您的账号已被激活，无需再次激活'
  )) . '<br /><a href="'.uri('users').'">'.i18n(array(
      'en' => 'login now',
      'zh' => '马上登录'
  )).'</a>'));
} else {
  $user->setEmailActivated(1);
  $user->save();
  Message::register(new Message(Message::SUCCESS, i18n(array(
      'en' => 'Congratulation! Your account has been successfully activated.',
      'zh' => '恭喜！您的账号已经被成功激活'
  )). '<br /><a href="'.uri('users').'">'.i18n(array(
      'en' => 'login now',
      'zh' => '马上登录'
  )).'</a>'));
}

HTML::forward('confirm');