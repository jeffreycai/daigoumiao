<div id="header">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <a href="<?php echo uri('') ?>"><img width="172" height="54" src="<?php echo uri('modules/site/assets/images/logo_full.png', false) ?>" alt="<?php echo $settings['sitename'] . "logo" ?>" /></a>
      </div>
      <div class="col-sm-4 col-sm-push-4">
        <form id="search-form" action="<?php echo uri('items/search') ?>" method="GET">
          <div class="input-group">
            <input type="text" class="form-control" name="keywords" placeholder="搜索产品" required />
            <span class="input-group-btn">
              <button class="btn btn-white" type="submit"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
      </div>
      <div class="col-sm-4 col-sm-pull-4">
        <?php if (isset($title)): ?>
        <h2><?php echo $title ?></h2>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>