<?php
$item_id = isset($vars[1]) ? $vars[1] : null;
$item = Item::findById($item_id);

if (is_null($item)) {
  dispatch('site/404');
  exit;
}

header("Location: " . $item->getOriginalLink());