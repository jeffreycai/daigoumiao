<?php 
$items = Item::findAllWithPage(1, 12);
?>

<div class="block" id="block-items">
  <div class="row">
<?php foreach($items as $item): ?>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
      <div class="card">
        <div class="thumb">
            <img src="<?php echo $item->getThumbnail() ?>" alt="<?php echo $item->getTitleEn() ?>" />
            <div class="label label-default rmb"><span style="font-size: 0.6em;">约</span>￥<?php echo round($item->getPrice() * 5.5, 2)  ?></div>
        </div>
        <h3><?php echo $item->getTitleEn() ?></h3>
        
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-6 info">
              澳洲实价:<br /> <span>AU$<?php echo $item->getPrice() ?></span>
            </div>
            <div class="col-xs-6 meta">
              <a href="" class="btn btn-sm btn-white">官网链接</a>
            </div>
          </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
    </div>
<?php endforeach; ?>
  </div>
</div>