<?php
require_once "BaseProduct.class.php";

class Product extends BaseProduct {
  public function getThumbnailUrl() {
    return get_sub_root() . '/files/products/' . $this->getThumbnail();
  }
  
  public function renderUpdateForm($action = '') {
    $settings = Vars::getSettings();
    
    // prepopulate vars
    $pid = $this->getId();
    $title = isset($_POST['title']) ? strip_tags($_POST['title']) : $this->getTitle();
    $description = isset($_POST['description']) ? $_POST['description'] : $this->getDescription();
    $active = isset($_POST['active']) ? true : ($this->getActive() ? true : false);
    $price = isset($_POST['price']) ? strip_tags($_POST['price']) : $this->getPrice();
    $thumbnail = $this->getThumbnail() ? $this->getThumbnailUrl() : null;
    
    // register assets
    // icheck
    HTML::registerHeaderUpper('<link href="/'.get_sub_root().'modules/site/assets/css/plugins/iCheck/custom.css" rel="stylesheet">');
    HTML::registerFooterUpper('<script src="/'.get_sub_root().'modules/site/assets/js/plugins/iCheck/icheck.min.js"></script>');
    
    
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


  <div class="form-group" id="form-field-thumbnail">
    <label for="thumbnail">缩略图</label>
    '.( $pid ? "<div><img src='" . $thumbnail . "' style='cursor: pointer;' /></div>" : '').'
    <input type="file" id="thumbnail" name="thumbnail"' .($pid ?  ' style="display: none;"' : '') . ' required="required" />
    <small>'.  i18n(array(
        'en' => 'Max image file size: ' . round($settings['profile']['avatar_max_size'] / 1000000, 1) . 'MB',
        'zh' => '最大图片上传尺寸： ' . round($settings['profile']['avatar_max_size'] / 1000000, 1) . 'MB'
    )).'</small>
  </div>


  <div class="form-group">
    <label class="control-label">是否上架</label>
    <div class="checkbox i-checks">
      <label class="control-label">
        <input type="checkbox" value="1" name="active" '.($active ? 'checked="checked"' : '').' /> <i></i> 上架?
      </label>
    </div>
  </div>
  <div class="form-group">
    <input type="submit" name="submit" value="'.(empty($pid) ? '添加' : '更新').'" class="btn btn-sm btn-primary" />&nbsp;&nbsp;&nbsp;
    <a href="'.uri('panel/admin/product/'.$this->getId().'/delete').'" onclick="return confirm(\'删除产品?\');">删除</a>
  </div>
  
  <input type="hidden" name="pid" value="'.$pid.'" />

</form>


<script type="text/javascript">
  $("#form-field-thumbnail img").click(function(){
    $("#thumbnail").trigger("click");
  });
  $("#thumbnail").change(function(){
    //$("#form-field-thumbnail img").fadeOut();
    $(this).fadeIn();
  });
</script>

';
    return $rtn;
  }
  
  public function delete() {
    unlink(PRODUCT_THUMBNAIL_DIR . '/' . $this->getThumbnail());
    foreach ($this->getSubProducts() as $sub_product) {
      $sub_product->delete();
    }
    return parent::delete();
  }
  
  public function getSubProducts($active = null) {
    global $mysqli;
    $query = "SELECT * FROM sub_product WHERE product_id=" . $this->getId();
    if ($active) {
      $query .= " AND active=".$active;
    }
    $result = $mysqli->query($query);
    $rtn  = array();
    while($record = $result->fetch_object()) {
      $sub_product = new SubProduct();
      DBObject::importQueryResultToDbObject($record, $sub_product);
      $rtn[] = $sub_product;
    }
    return $rtn;
  }
}
