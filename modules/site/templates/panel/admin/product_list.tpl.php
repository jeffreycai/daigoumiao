<div class="row">
  <div class="col-lg-12">
    <div class="wrapper wrapper-content">
      <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="ibox float-e-margins product">
            <img src="<?php echo $product->getThumbnailUrl() ?>" class="img-responsive" />
            <div class="ibox-content">
              <div class="title">
                <?php echo $product->getTitle() ?>
              </div>
              <div class="btn-group">
                <a class="btn btn-white btn-sm" href="<?php echo uri('panel/admin/product/'.$product->getId().'/edit') ?>"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        
        
        
      </div>
    </div>
  </div>
</div>