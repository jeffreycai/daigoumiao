<?php

function cw_crawl_product($args) {
  
  $url = $args['url'];
  $tags = $args['tags'];
  $tags = explode(',', $tags);
  $brand_id = empty($args['brand']) ? null : $args['brand'];
  $vendor = Vendor::findByName('Chemist Warehouse');
  if (is_null($vendor)) {
    $vendor = new Vendor();
    $vendor->setName('Chemist Warehouse');
    $vendor->save();
  }
  $vendor_id = $vendor->getId();
  
  $html = file_get_contents($url);
  if (!$html) {
    throw new Exception('Failed to read product list page: ' . $url);
  }
  
  $matches1 = array();
  preg_match_all('/<a href="product\.asp\?id=[^>]+><img src=[^<]+<\/a>/', $html, $matches1);
  $matches2 = array();
  preg_match_all('/<span id=\'our_price[^>]+>\s+\$\d+(\.\d+)?\s+<\/span>/', $html, $matches2);
  if (!isset($matches1[0]) || !isset($matches2[0]) || sizeof($matches1[0]) != sizeof($matches2[0])) {
    throw new Exception('Product and price pair number don\'t match. for product list page: '. $url);
  }
  for ($i = 0; $i < sizeof($matches1[0]); $i++) {
    $matches = array();
    preg_match('/id=(\d+)\&pname=([^"]+)"><img src="([^"]+)"/', $matches1[0][$i], $matches);
    $pid = $matches[1];
    $title = urldecode($matches[2]);
    $thumbnail = $matches[3];
    
    $matches = array();
    preg_match('/\$(\d+(.\d+)?)/', $matches2[0][$i], $matches);
    $price = $matches[1];

    if (!empty($pid) && !empty($title) && !empty($thumbnail) && !empty($price)) {
      $item = Item::findByOriginalId($pid);
      if (is_null($item)) {
        $item = new Item();
      } else {
        // we don't update the record if it was updated with 24 hours
        $updated_at = $item->getUpdatedAt();
        if ($updated_at > time() - (24 * 60 * 60)) {
          continue;
        }
      }
      
      // for new product, we update all fields
      if ($item->isNew()) {
        $item->setOriginalId($pid);
        $item->setPrice($price);
        $item->setThumbnail('http://chemistwarehouse.com.au'.$thumbnail);
        $item->setTitleEn(($title));
        $item->setUpdatedAt(time());
        $item->setVendorId($vendor_id);
        if ($brand_id) {
          $item->setBrandId($brand_id);
        }
      // for existing product, we update price only
      } else {
        $item->setUpdatedAt(time());
        $item->setPrice($price);
      }

      if ($item->save()) {
        // handle tags
        // remove all existing tags
        $item->deleteAllTags();
        // add new tags
        foreach ($tags as $tag) {
          if (!empty($tag)) {
            $ic = new ItemTag();
            $ic->setTagId(intval($tag));
            $ic->setItemId($item->getId());
            $ic->save();
          }
        }
      }
    } else {
      throw new Exception('Product fields missing for product on product list page: ' . $url);
    }
  }
  return true;
}