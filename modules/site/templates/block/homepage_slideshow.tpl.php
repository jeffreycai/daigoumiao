<div class="block" id="block-homepage-slideshow">
  <div class="row">
    <div class="col-sm-8 col-sm-push-4">
      <!-- Place somewhere in the <body> of your page -->
      <div class="flexslider">
        <ul class="slides">
          <li>
            <img src="http://placehold.it/800x504" />
          </li>
          <li>
            <img src="http://placehold.it/800x504" />
          </li>
          <li>
            <img src="http://placehold.it/800x504" />
          </li>
          <li>
            <img src="http://placehold.it/800x504" />
          </li>
        </ul>
      </div>
    </div>
    <div class="col-sm-4 col-sm-pull-8">
      <h2>产品分类</h2>
      <div style="margin-bottom: 10px;">
        <?php foreach (Category::findAll() as $cat): ?>
        <a href="" class="simple_tag"><?php echo $cat->getName() ?></a>
        <?php endforeach; ?>
      </div>
      <h2>热门标签</h2>
      <div>
        <?php foreach (Category::findAll() as $cat): ?>
        <a href="" class="simple_tag"><?php echo $cat->getName() ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>