<div class="block" id="block-taxonomy-nav">
  <div class="panel blank-panel">

    <div class="panel-heading">
      <div class="panel-options">

        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">热门标签</a></li>
          <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">热门品牌</a></li>
        </ul>
      </div>
    </div>

    <div class="panel-body">

      <div class="tab-content">
        <div class="tab-pane active" id="tab-1">
          <?php foreach (Tag::findAll() as $tag): ?>
          <div class="simple_tag"><a href="<?php echo uri('items/tag/' . $tag->getId()) ?>"><?php echo $tag->getName() ?></a></div>
          <?php endforeach; ?>
        </div>

        <div class="tab-pane" id="tab-2">
          <?php foreach (Brand::findAll() as $brand): ?>
          <div class="simple_tag"><a href="<?php echo uri('items/brand/' . $brand->getId()) ?>"><?php echo $brand->getName() ?></a></div>
          <?php endforeach; ?>
        </div>

      </div>

    </div>

  </div>
  
</div>