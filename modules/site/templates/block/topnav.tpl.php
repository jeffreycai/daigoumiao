<nav id="topnav">
  <div class="container">
    <ul>
      <li class="active"><a href="#"><?php
          echo i18n(array(
              'en' => 'Home',
              'zh' => '首页'
          ))
          ?></a></li>
      <li><a href="#about">About</a></li>
      <li><a href="<?php echo uri('contact') ?>"><?php echo i18n(array(
          'en' => 'Content',
          'zh' => '联系'
      )) ?></a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li class="dropdown-header">Nav header</li>
          <li><a href="#">Separated link</a></li>
          <li><a href="#">One more separated link</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>