
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php i18n_echo(array('en' => 'Please Sign in', 'zh' => '请先登录')); ?></h3>
        </div>
        <div class="panel-body">
          <?php echo Message::renderMessages(); ?>
          <form role="form" action="" method="post" id="login">
            <fieldset>
              <div class="form-group">
                <input class="form-control" placeholder="<?php i18n_echo(array('en' => 'E-mail', 'zh' => '电子邮件')) ?>" name="email" type="email" autofocus required="">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="<?php i18n_echo(array('en' => 'Password', 'zh' => '密码')) ?>" name="password" type="password" value="" required="">
              </div>
              <div class="checkbox">
                <label>
                  <input name="remember" type="checkbox" value="Remeber me" <?php if (isset($_POST['remember'])): ?>checked="checked"<?php endif; ?>><?php i18n_echo(array('en' => 'Remember Me', 'zh' => '下次自动登录')) ?>
                </label>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="submit" class="btn btn-lg btn-success btn-block disabled" value="<?php i18n_echo(array('en' => 'Login', 'zh' => '登录')) ?>" />
              <?php Form::loadSpamToken('#login', UID_BACKEND_LOGIN_FORM); ?>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
