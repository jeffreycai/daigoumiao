<div class="row">
  <div class="col-lg-12">
    <div class="wrapper wrapper-content">
      <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="ibox float-e-margins">
            <div class="ibox-content">
            <img src="<?php echo $product->getThumbnailUrl() ?>" class="img-responsive" />
            <p><?php echo $product->getTitle() ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        
        
        
      </div>
    </div>
  </div>
</div>