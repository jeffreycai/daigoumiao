<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2><?php echo (isset($title) ? $title : '') ?></h2>
    <ol class="breadcrumb">
      <?php $i = 0; ?>
      <?php foreach ($breadcrumb as $name => $val): $i++; $isLast = $i == sizeof($breadcrumb); ?>
        <?php if (is_array($val)): 
          
          
//                        <div class="dropdown profile-element"> <span>
//                            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
//                             </span>
//                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
//                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
//                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
//                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
//                                <li><a href="profile.html">Profile</a></li>
//                                <li><a href="contacts.html">Contacts</a></li>
//                                <li><a href="mailbox.html">Mailbox</a></li>
//                                <li class="divider"></li>
//                                <li><a href="login.html">Logout</a></li>
//                            </ul>
//                        </div>
          
          
          echo '<li class="dropdown profile-element">';
          echo '<a data-toggle="dropdown" class="dropdown-toggle" href="#">';
          echo '<span>'.$name.' <b class="caret"></b></span></a> ';
          echo '<ul class="dropdown-menu animated fadeInRight m-t-xs">';
        foreach ($val as $subname => $subval): ?>
          <li><a href="<?php echo $subval ?>"><?php echo $subname ?></a></li>
        <?php endforeach; 
          echo '</ul>';
          echo '</li>';
        else: ?>
          <li>
            <?php if (empty($val)): ?>
              <?php echo $isLast ? "<strong>$name</strong>" : $name; ?>
            <?php else: ?>
              <a href="<?php echo $val ?>"><?php echo $name ?></a>
            <?php endif; ?>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>

    </ol>
  </div>
  <div class="col-lg-2">

  </div>
</div>