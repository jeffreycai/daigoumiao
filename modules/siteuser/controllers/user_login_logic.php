<?php

$username = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : null;
$password = isset($_POST['password']) ? trim(strip_tags($_POST['password'])) : null;
$referer = isset($_POST['referer']) ? trim(strip_tags($_POST['referer'])) : null;
$remember = isset($_POST['remember']) ? trim(strip_tags($_POST['remember'])) : null;

$user = null;

/**  validation **/
$messages = array();
if (empty($username)) {
  $messages[] = new Message(Message::DANGER, i18n(array(
      'en' => 'Please enter your e-mail or username',
      'zh' => '请填写电子邮箱或用户名'
  )));
}
if (empty($password)) {
  $messages[] = new Message(Message::DANGER, i18n(array(
      'en' => 'Please enter your password',
      'zh' => '请填写密码'
  )));
}

if (!empty($messages)) {
  Message::register($messages);
  $_SESSION['siteuser_login_referer'] = $referer;
  HTML::forwardBackToReferer();
}

// check if user exists
if (strpos($username, '@') == false) {
  $user = SiteUser::findByUsername($username);
} else {
  $user = SiteUser::findByEmail($username);
}
if (is_null($user) || !$user->checkPassword($password)) {
  Message::register(new Message(Message::DANGER, i18n(array(
      'en' => 'Username and password don\'t match. Please try again',
      'zh' => '用户名和密码不匹配，请重新尝试'
  ))));
  $_SESSION['siteuser_login_referer'] = $referer;
  HTML::forwardBackToReferer();
}

// check spam
if (module_enabled('form') && !Form::checkSpamToken(UID_BACKEND_LOGIN_FORM)) {
  $message = new Message(Message::DANGER, i18n(array(
      'en' => 'Form login session expired. Please try again',
      'zh' => '表单提交时限过期，请重新尝试登录'
  )));
  Message::register($message);
  $_SESSION['siteuser_login_referer'] = $referer;
  HTML::forwardBackToReferer();
}

/** login action **/
$user->login(is_null($remember) ? false : true);
// forward back to referer if exists
unset($_SESSION['siteuser_login_referer']);
if (!empty($referer) && !preg_match('/\/users$/', $referer)) {
  HTML::forward($referer);
}
HTML::forward('');