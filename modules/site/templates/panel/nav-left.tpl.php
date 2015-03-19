<?php 
$user = SiteUser::getCurrentUser(); 
$profile = $user->getProfile();
?>


<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element"> <span>
            <img alt="用户头像" class="img-circle" style="width: 48px; height: 48px;" src="<?php echo $profile->getThumbnailUrl() ?>" />
          </span>
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $profile->getNickname() ?></strong>
              </span> <span class="text-muted text-xs block">账号管理 <b class="caret"></b></span> </span> </a>
          <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a href="<?php echo uri('panel/user/profile') ?>">更改个人信息</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo uri('users/logout') ?>">登出</a></li>
          </ul>
        </div>
        <div class="logo-element">
          代
        </div>
      </li>
      <li<?php echo_link_active_class('/^panel\/?$/', get_cur_page_url()) ?>>
        <a href="<?php echo uri('panel') ?>"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span></a>
      </li>
      <?php if ($user->hasPermission('order products')): ?>
      <li<?php echo_link_active_class('/^panel\/affiliator\/order\/?$/', get_cur_page_url()) ?>>
        <a href="<?php echo uri('panel/affiliator/order') ?>"><i class="fa fa-shopping-cart"></i> <span class="nav-label">下订单</span></a>
      </li>
      <?php endif; ?>
      
      <?php if ($user->hasPermission('manage products')): ?>
      <li<?php echo_link_active_class('/^panel\/admin\/product/', get_cur_page_url()) ?>>
        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">商品</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li<?php echo_link_active_class('/^panel\/admin\/product\/list\/?$/', get_cur_page_url()) ?>><a href="<?php echo uri('panel/admin/product/list') ?>">所有商品列表</a></li>
          <li<?php echo_link_active_class('/^panel\/admin\/product\/add\/?$/', get_cur_page_url()) ?>><a href="<?php echo uri('panel/admin/product/add') ?>">添加商品</a></li>
        </ul>
      </li>
      <?php endif; ?>
    </ul>

  </div>
</nav>