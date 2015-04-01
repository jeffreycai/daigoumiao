<?php
$id = isset($vars[1]) ? strip_tags($vars[1]) : null;
$item = Item::findById($id);

if (is_null($item)) {
  dispatch('core/404');
  exit;
}


// get vars from $_POST
$title_zh = trim(strip_tags($_POST['title_zh']));
$brand_name = trim(strip_tags($_POST['brand']), ' ,');
$tags = trim(strip_tags($_POST['tags']), ' ,');

$item->setTitleZh($title_zh);


$brand = Brand::findByName($brand_name);
if ($brand_name == "") {
  $item->setBrandId(1);
} else if (is_null($brand)) {
  $brand = new Brand();
  $brand->setName($brand_name);
  $brand->save();
  $item->setBrandId($brand->getId());
} else {
  $item->setBrandId($brand->getId());
}

$item->deleteAllTags();
if (!empty($tags)) {
  $item->createTagsFromString($tags);
}

$item->save();


// respond to ajax
header('Content-Type: application/json');
echo json_encode(array(
    'title_zh' => $item->getTitleZh(),
    'brand' => $item->getBrandInString(),
    'tags' => $item->getTagsInString()
));




