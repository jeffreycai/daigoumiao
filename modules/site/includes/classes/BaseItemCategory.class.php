<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - item_id
 * - category_id
 */
class BaseItemCategory extends DBObject {
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
    $this->table_name = 'item_category';
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
   public function setItemId($var) {
     $this->setDbFieldItem_id($var);
   }
   public function getItemId() {
     return $this->getDbFieldItem_id();
   }
   public function setCategoryId($var) {
     $this->setDbFieldCategory_id($var);
   }
   public function getCategoryId() {
     return $this->getDbFieldCategory_id();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('item_category');
  }
  
  static function tableExist() {
    return parent::tableExistByName('item_category');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `item_category` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `item_id` INT ,
  `category_id` INT ,
  PRIMARY KEY (`id`)
 ,
INDEX `fk-item_category-category_id-idx` (`category_id` ASC),
CONSTRAINT `fk-item_category-category_id`
  FOREIGN KEY (`category_id`)
  REFERENCES `category` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE ,
INDEX `fk-item_category-item_id-idx` (`item_id` ASC),
CONSTRAINT `fk-item_category-item_id`
  FOREIGN KEY (`item_id`)
  REFERENCES `item` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'ItemCategory') {
    global $mysqli;
    $query = 'SELECT * FROM item_category WHERE id=' . $id;
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
    $query = "SELECT * FROM item_category";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new ItemCategory();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM item_category LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new ItemCategory();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM item_category";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE item_category";
    return $mysqli->query($query);
  }
}