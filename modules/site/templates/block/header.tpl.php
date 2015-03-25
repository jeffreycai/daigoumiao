<div id="header">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <a href="<?php echo uri('') ?>"><img width="172" height="54" src="<?php echo uri('modules/site/assets/images/logo.png', false) ?>" alt="<?php echo $settings['sitename'] . "logo" ?>" /></a>
      </div>
      <div class="col-sm-4">
        <form id="search-form" action="<?php echo uri('search') ?>" method="GET">
          <div class="input-group">
            <input type="text" class="form-control" name="keyword" placeholder="实价搜索" />
            <span class="input-group-btn">
              <button class="btn btn-white" type="submit"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>