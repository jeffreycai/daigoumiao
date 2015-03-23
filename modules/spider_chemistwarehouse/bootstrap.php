<?php
// dependency check
if (!module_enabled('queue')) {
  die('Please enable queue module');
}


$user = User::getInstance();
if (!is_cli() && $user->isLogin() && is_backend()) {
  
  // register dashboard
  Backend::registerDashboard(
  '
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          Chemist Warehouse
        </div>
        <div class="panel-body">
          <ul>
            <li><a href="'.uri('admin/cw/url-list').'">Url list to crawl</a></li>
          </ul>
        </div>
      </div>
    </div>

  </div>
  '
  );

}