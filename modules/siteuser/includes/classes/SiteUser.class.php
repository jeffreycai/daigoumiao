<?php
require_once "BaseSiteUser.class.php";

class SiteUser extends BaseSiteUser {
  static function renderUpdateFormBackend(SiteUser $user = null, $action = '') {
    // set default action value
    if ($action != '') {
      $action = uri($action);
    }
    
    // get vars from form submission
    $username = isset($_POST['username'])  ? strip_tags($_POST['username'])  : (isset($user) ? $user->getUsername()  : '');
    $email    = isset($_POST['email'])     ? strip_tags($_POST['email'])     : (isset($user) ? $user->getEmail()     : '');
    $password = '';
    $password_confirm = '';
    $active   = isset($_POST['active'])    ? strip_tags($_POST['active'])    : (isset($user) ? $user->getActive()    : false);
    
    $mandatory_label = ' <span style="color: rgb(185,2,0); font-weight: bold;">*</span>';
    
    $roles_form_markup = '<div id="form-field-roles"><label>Roles</label><ul class="checkbox">';
    foreach (SiteRole::findAll() as $role) {
      $roles_form_markup .= '<li><label><input type="checkbox" name="roles['.$role->getid().']" value=1 '.(isset($_POST['roles'][$role->getId()]) ? 'checked="checked"' : ($user &&$user->hasRole($role->getName()) ? 'checked="checked"' : '')).' />' . $role->getName() . '</label></li>';
    }
    $roles_form_markup .= '</ul></div>';
    
    $rtn = '
<form action="'.$action.'" method="POST" id="adduser" enctype="multipart/form-data">
  <div class="form-group" id="form-field-username">
    <label for="username">'.i18n(array('en' => 'Username', 'zh' => '用户名')).$mandatory_label.'</label>
    <input type="text" class="form-control" id="username" name="username" value="'.$username.'" required placeholder="" />
  </div>
  <div class="form-group" id="form-field-email" >
    <label for="email">'.i18n(array('en' => 'Email', 'zh' => '电子邮箱')).$mandatory_label.'</label>
    <input type="email" class="form-control" id="email" name="email" value="'.$email.'" required />
  </div>
  <div class="form-group" id="form-field-password">
    <label for="password">'.i18n(array('en' => 'Password', 'zh' => '密码')).$mandatory_label.'</label>
    <input type="password" class="form-control" id="password" name="password" value="'.$password.'" required />
  </div>
  <div class="form-group" id="form-field-password_confirm">
    <label for="password_confirm">'.i18n(array('en' => 'Password again', 'zh' => '再次确认密码')).$mandatory_label.'</label>
    <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="'.$password_confirm.'" required />
  </div>
  ' . (class_exists('SiteProfile') ? SiteProfile::renderUpdateForm($user) : '') . '
  <div class="checkbox" id="form-field-active">
    <label>
      <input type="checkbox" id="active" name="active" value="1" '.($active == false ? '' : 'checked="checked"').'> '.  i18n(array('en' => 'Active?', 'zh' => '有效用户')).'
    </label>
  </div>
  ' . (is_backend() ? $roles_form_markup : '') . '
  <div class="form-group" id="form-field-notice"><small><i>
    '.$mandatory_label.i18n(array(
        'en' => ' indicates mandatory fields',
        'zh' => ' 标记为必填项'
    )).'
  </i></small></div>
  <button type="submit" name="submit" class="btn btn-primary">'.(is_null($user) 
            ? i18n(array('en' => 'Add new user', 'zh' => '添加新用户')) 
            : i18n(array('en' => 'Update user', 'zh' => '更新用户'))).'</button>
</form>
';
    return $rtn;
  }
  
  
  static function findByUsername($username) {
    global $mysqli;
    $query = 'SELECT * FROM site_user WHERE username=' . DBObject::prepare_val_for_sql($username);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new SiteUser();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findByEmail($email) {
    global $mysqli;
    $query = 'SELECT * FROM site_user WHERE email=' . DBObject::prepare_val_for_sql($email);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new SiteUser();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  public function putPassword($password) {
    $this->setSalt(get_random_string(16));
    $this->setPassword(md5($this->getSalt().$password));
  }
  
  public function getProfile() {
    if (class_exists('SiteProfile')) {
      return SiteProfile::findByUId($this->getId());
    }
    return null;
  }
  
  static function renderLoginForm() {
    $referer = (isset($_SESSION['siteuser_login_referer']) ? $_SESSION['siteuser_login_referer'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''));
    
    $rtn = Message::renderMessages() . '
<form role="form" action="'.uri('users/login', false).'" method="post" id="login">
  <fieldset>
    <div class="form-group">
      <label for="email">'.i18n(array('en' => 'E-mail or username', 'zh' => '电子邮件或者用户名')).'</label>
      <input class="form-control" name="email" id="email" autofocus required="">
    </div>
    <div class="form-group">
      <label for="password">'.i18n(array('en' => 'Password', 'zh' => '密码')).'</label>
      <input class="form-control" name="password" id="password" type="password" value="" required="">
    </div>
    <div class="form-group">
      <label>
      <input type="checkbox" name="remember" value="1" /> '.i18n(array('en' => 'Remember me', 'zh' => '记住我')).'
      </label>
    </div>
    <input type="submit" name="submit" class="btn btn-lg btn-success btn-block '.(module_enabled('form') ? 'disabled' : '').'" value="'.i18n(array('en' => 'Login', 'zh' => '登录')).'" />
    <input type="hidden" name="referer" value="'.$referer.'" />
    '.(module_enabled('form') ? Form::loadSpamToken('#login', UID_BACKEND_LOGIN_FORM) : '').'
  </fieldset>
</form>
';
    return $rtn;
  }
  
  public function checkPassword($password) {
    return md5($this->getSalt().$password) == $this->getPassword();
  }
  
  /**
   * Login the user and store in session and cookie
   */
  public function login($remember) {
    global $siteuser;
    
    self::getCurrentUser()->logout();
    
    $siteuser = $this;
    $_SESSION['siteuser_id'] = $this->getId();
    $_SESSION['siteuser_password'] = $this->getPassword();
    if ($remember) {
      setcookie('siteuser_id', $this->getid(), (time() + (3600 * 24 * 30)), '/' .  get_sub_root());
      setcookie('siteuser_password', $this->getPassword(), (time() + (3600 * 24 * 30)), '/' . get_sub_root());
    }
    
    $_SESSION['siteuser_permissions'] = array();
    foreach ($this->getPermissions() as $p) {
      $_SESSION['siteuser_permissions'][] = $p->getName();
    }
    $_SESSION['siteuser_roles'] = array();
    foreach ($this->getRoles() as $r) {
      $_SESSION['siteuser_roles'][] = $r->getName();
    }
  }
  
  public function isLogin() {
    $user = self::getCurrentUser();
    return $user->getId() == $this->getId();
  }


  public function logout() {
    global $siteuser;
    unset($siteuser);
    unset($_SESSION['siteuser_id']);
    unset($_SESSION['siteuser_password']);
    unset($_SESSION['siteuser_permissions']);
    unset($_SESSION['siteuser_roles']);
    setcookie('siteuser_id', null, time()-3600, '/' . get_sub_root());
    setcookie('siteuser_password', null, time()-3600, '/' . get_sub_root());
  }

  /**
   * get current user from session or cookie
   * 
   * @global type $siteuser
   * @return type
   */
  static function getCurrentUser() {
    // try to get user from global var
    global $siteuser;
    if (isset($siteuser)) {
      return $siteuser;
    }
    
    // try to get user from session
    $uid = isset($_SESSION['siteuser_id']) ? $_SESSION['siteuser_id'] : null;
    if ($uid && $user = SiteUser::findById($uid)) {
      $password = isset($_SESSION['siteuser_password']) ? $_SESSION['siteuser_password'] : 0;
      if ($user->getPassword() == $password) {
        $siteuser = $user;
        return $user;
      }
    }
    
    // try to get user from cookie
    $uid = isset($_COOKIE['siteuser_id']) ? $_COOKIE['siteuser_id'] : null;
    if ($uid && $user = SiteUser::findById($uid)) {
      $password = isset($_COOKIE['siteuser_password']) ? $_COOKIE['siteuser_password'] : 0;
      if ($user->getPassword() == $password) {
        $siteuser = $user;
        $_SESSION['siteuser_id'] = $uid;
        $_SESSION['siteuser_password'] = $password;
        return $user;
      }
    }

    // if nothing succeeds in former attempts, return empty user
    $user = new SiteUser();
    $user->setId(-1);
    $siteuser = $user;
    
    return $user;
  }
  
  public function getRoles() {
    $urs = SiteUserRole::findByUid($this->getId());
    $role_ids = array();
    foreach ($urs as $ur) {
      $role_ids[] = $ur->getRoleId();
    }
    
    global $mysqli;
    $query = "SELECT * FROM site_role WHERE id IN (".implode(',', $role_ids).")";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new SiteRole();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  public function getPermissions() {
    $permissions = array();
    $pids = array();
    foreach ($this->getRoles() as $role) {
      foreach ($role->getPermissions() as $permission) {
        if (!in_array($permission->getId(), $pids)) {
          $pids[] = $permission->getId();
          $permissions[] = $permission;
        } else {
          continue;
        }
      }
    }
    return $permissions;
  }

  
  public function hasPermission($ps) {
    // get self permessions in an array()
    $permissions = array();
    foreach ($this->getPermissions() as $permission) {
      $permissions[] = $permission->getName();
    }
    
    // loop to check
    // for a group of permissions
    if (is_array($ps)) {
      foreach ($ps as $p) {
        if (!in_array($p, $permissions)) {
          return false;
        }
      }
      return true;
    // for a single permission
    } else {
      return in_array($ps, $permissions);
    }
  }
  
  public function hasRole($rs) {
    // get self permessions in an array()
    $roles = array();
    foreach ($this->getRoles() as $role) {
      $roles[] = $role->getName();
    }
    
    // loop to check
    // for a group of roles
    if (is_array($rs)) {
      foreach ($rs as $r) {
        if (!in_array($r, $roles)) {
          return false;
        }
      }
      return true;
    // for a single permission
    } else {
      return in_array($rs, $roles);
    }
  }
}
