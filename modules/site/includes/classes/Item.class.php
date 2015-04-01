<?php
require_once "BaseItem.class.php";

class Item extends BaseItem {
  static function findByOriginalId($oid, $instance = 'Item') {
    global $mysqli;
    $query = 'SELECT * FROM item WHERE original_id=' . $oid;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  public function getOriginalImage() {
    $thumbnail = $this->getThumbnail();
//    $thumbnail = str_replace('chemistwarehouse.com.au', 'px.websitesydney.net', $thumbnail);
    return preg_replace('/\d+_cw\.jpg/i', 'original_CW.jpg', $thumbnail);
  }
  
  public function getOriginalLink() {
    return "http://www.chemistwarehouse.com.au/product.asp?id=" . $this->getOriginalId();
  }
  
  static function countAllByTag($tag) {
    // get tag_id
    $tid = null;
    if (is_object($tag) && is_a($tag, 'Tag')) {
      $tid = $tag->getId();
    } else if (is_string($tag) && !preg_match('/^\d+$/', $tag)) {
      $tag = Tag::findByName($tag);
      $tag = $tag ? $tag->getId() : null;
    } else {
      $tid = $tag;
    }
    if ($tid == null) {
      return 0;
    }
    
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM item_tag WHERE tag_id=" . $tid;
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function findAllByTagWithPage($tag, $page, $entries_per_page) {
    // get tag_id
    $tid = null;
    if (is_object($tag) && is_a($tag, 'Tag')) {
      $tid = $tag->getId();
    } else if (is_string($tag)) {
      $tag = Tag::findByName($tag);
      $tag = $tag ? $tag->getId() : null;
    } else if (is_int($tag)) {
      $tid = $tag;
    }
    if ($tid == null) {
      return false;
    }
    
    global $mysqli;
    $query = "SELECT i.* FROM item as i, item_tag as it WHERE i.id=it.item_id AND it.tag_id=$tid LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Item();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  public function getBrand() {
    $bid = $this->getBrandId();
    return Brand::findById($bid);
  }
  
  public function getBrandInString() {
    return $this->getBrand()->getName();
  }
  
  public function getTags() {
    global $mysqli;
    $query = "SELECT tag_id as tid FROM item_tag WHERE item_id=" . $this->getId();
    $result = $mysqli->query($query);
    $tags = array();
    if ($result) {
      while ($record = $result->fetch_object()) {
        if ($tag = Tag::findById($record->tid)) {
          $tags[] = $tag;
        }
      }
    }
    return $tags;
  }
  
  public function getTagsInString() {
    $tags = $this->getTags();
    $rtn = array();
    foreach ($tags as $tag) {
      $rtn[] = $tag;
    }
    return implode(", ", $rtn);
  }
  
  public function deleteAllTags() {
    global $mysqli;
    $query = "DELETE FROM item_tag WHERE item_id=" . $this->getId();
    return $mysqli->query($query);
  }
  
  public function createTagsFromString($string) {
    $string = trim($string, ', ');
    $tokens = explode(",", $string);
    foreach ($tokens as $token) {
      $token = trim($token);
      if (!empty($token)) {
        $tag = Tag::findByName($token);
        if ($tag) {
          $it = new ItemTag();
          $it->setItemId($this->getId());
          $it->setTagId($tag->getId());
          $it->save();
        }
      }
    }
  }
  
  static function countAllTitleZh() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM item WHERE title_zh IS NOT NULL AND title_zh != ''";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function findAllTitleZhWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM item WHERE title_zh IS NOT NULL AND title_zh != '' LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Item();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
}
