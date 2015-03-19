<?php
require_once "BaseProduct.class.php";

class Product extends BaseProduct {
  public function getThumbnailUrl() {
    return get_sub_root() . '/files/products/' . $this->getThumbnail();
  }
  
  public function renderUpdateForm($action = '') {
    // prepopulate vars
    $pid = $this->getId();
    $title = isset($_POST['title']) ? strip_tags($_POST['title']) : $this->getTitle();
    $description = isset($_POST['description']) ? $_POST['description'] : $this->getDescription();
    $active = isset($_POST['active']) ? true : ($this->getActive() ? true : false);
    $price = isset($_POST['price']) ? strip_tags($_POST['price']) : $this->getPrice();
    $thumbnail = $this->getThumbnailUrl();
    
    // register assets
    // icheck
    HTML::registerHeaderUpper('<link href="/'.get_sub_root().'modules/site/assets/css/plugins/iCheck/custom.css" rel="stylesheet">');
    HTML::registerFooterUpper('<script src="/'.get_sub_root().'modules/site/assets/js/plugins/iCheck/icheck.min.js"></script>');
    // image cropper
    HTML::registerFooterUpper('<script src="/'.get_sub_root().'modules/site/assets/js/plugins/cropper/cropper.min.js"></script>');
    HTML::registerHeaderUpper('<link href="/'.get_sub_root().'modules/site/assets/css/plugins/cropper/cropper.min.css" rel="stylesheet">');
    
    
    $rtn = Message::renderMessages() . '
<form id="product" action="'.$action.'" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label class="control-label" for="title">标题</label>
    <input id="title" name="title" class="form-control" type="text" required value="'.$title.'" />
  </div>
  <div class="form-group">
    <label class="control-label" for="price">价格</label>
    <input id="price" name="price" class="form-control" type="text" value="'.$price.'" />
  </div>
  <div class="form-group">
    <label class="control-label">缩略图</label>


<div class="row" id="makeThumbnail">
  <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="image-crop">
      <img src="/files/avatars/default.gif" />
    </div>
    <div>
      <h4>缩略图预览</h4>
      <div style="width: 150px; height: 150px;" class="img-preview img-preview-sm"></div>
      <div class="btn-group">
        <label title="Upload image file" for="inputImage" class="btn btn-primary">
          <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
          上传新图片
        </label>
        <label title="Donload image" id="download" class="btn btn-primary">Download</label>
      </div>
    </div>
  </div>
</div>


  </div>
  <div class="form-group">
    <div class="checkbox i-checks">
      <label class="control-label">
        <input type="checkbox" value="1" name="active" '.($active ? 'checked="checked"' : '').' /> <i></i> 上架?
      </label>
    </div>
  </div>
  <div class="form-group">
    <input type="submit" name="submit" value="'.(empty($pid) ? '添加' : '更新').'" class="btn btn-sm btn-primary" />
  </div>
  
  <input type="hidden" name="pid" value="'.$pid.'" />

</form>


<script type="text/javascript">
jQuery(function(){
  var $image = $(".image-crop > img");

  $($image).cropper({
      aspectRatio: 1,
      preview: ".img-preview",
      done: function(data) {
          // Output the result data for cropping image.
      }
  });
  var $inputImage = $("#inputImage");
  if (window.FileReader) {
      $inputImage.change(function() {
          var fileReader = new FileReader(),
                  files = this.files,
                  file;

          if (!files.length) {
              return;
          }

          file = files[0];

          if (/^image\/\w+$/.test(file.type)) {
              fileReader.readAsDataURL(file);
              fileReader.onload = function () {
                  $inputImage.val("");
                  $image.cropper("reset", true).cropper("replace", this.result);
              };
          } else {
              showMessage("Please choose an image file.");
          }
      });
  } else {
      $inputImage.addClass("hide");
  }
  
  $("#download").click(function() {
      window.open($image.cropper("getDataURL"));
  });
});
</script>

';
    return $rtn;
  }
}
