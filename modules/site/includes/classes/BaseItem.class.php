<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - original_id
 * - title_en
 * - title_zh
 * - thumbnail
 * - price
 * - updated_at
 */
class BaseItem extends DBObject {
  /**
   * Implement parent abstract functions
   */
  protected function setPrimaryKeyName() {
    $this->primary_key = array(
      'id'
    );
  }
  protected function setPrimaryKeyAutoIncreased() {
    $this->pk_auto_increased = TRUE;
  }
  protected function setTableName() {
    $this->table_name = 'item';
  }
  
  /**
   * Setters and getters
   */
   public function setId($var) {
     $this->setDbFieldId($var);
   }
   public function getId() {
     return $this->getDbFieldId();
   }
   public function setOriginalId($var) {
     $this->setDbFieldOriginal_id($var);
   }
   public function getOriginalId() {
     return $this->getDbFieldOriginal_id();
   }
   public function setTitleEn($var) {
     $this->setDbFieldTitle_en($var);
   }
   public function getTitleEn() {
     return $this->getDbFieldTitle_en();
   }
  public function setTitle($var, $lang = null) {
    $lang = is_null($lang) ? get_language() : $lang;
    
    $method = "setTitle" . ucfirst($lang);
    $this->{$method}($var);
  }
  public function getTitle($lang = null) {
    $lang = is_null($lang) ? get_language() : $lang;
    
    $method = "getTitle" . ucfirst($lang);
    return $this->{$method}();
  }
   public function setTitleZh($var) {
     $this->setDbFieldTitle_zh($var);
   }
   public function getTitleZh() {
     return $this->getDbFieldTitle_zh();
   }
   public function setThumbnail($var) {
     $this->setDbFieldThumbnail($var);
   }
   public function getThumbnail() {
     return $this->getDbFieldThumbnail();
   }
   public function setPrice($var) {
     $this->setDbFieldPrice($var);
   }
   public function getPrice() {
     return $this->getDbFieldPrice();
   }
   public function setUpdatedAt($var) {
     $this->setDbFieldUpdated_at($var);
   }
   public function getUpdatedAt() {
     return $this->getDbFieldUpdated_at();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('item');
  }
  
  static function tableExist() {
    return parent::tableExistByName('item');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `item` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `original_id` INT ,
  `title_en` VARCHAR(512) ,
  `title_zh` VARCHAR(512) ,
  `thumbnail` VARCHAR(256) ,
  `price` VARCHAR(6) ,
  `updated_at` INT ,
  PRIMARY KEY (`id`)
 ,
INDEX `item_original_id` (`original_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'Item') {
    global $mysqli;
    $query = 'SELECT * FROM item WHERE id=' . $id;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findAll() {
    global $mysqli;
    $query = "SELECT * FROM item";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Item();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM item LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Item();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM item";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE item";
    return $mysqli->query($query);
  }
}