<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - item_id
 * - tag_id
 */
class BaseItemTag extends DBObject {
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
    $this->table_name = 'item_tag';
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
   public function setTagId($var) {
     $this->setDbFieldTag_id($var);
   }
   public function getTagId() {
     return $this->getDbFieldTag_id();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('item_tag');
  }
  
  static function tableExist() {
    return parent::tableExistByName('item_tag');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `item_tag` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `item_id` INT ,
  `tag_id` INT ,
  PRIMARY KEY (`id`)
 ,
INDEX `fk-item_tag-tag_id-idx` (`tag_id` ASC),
CONSTRAINT `fk-item_tag-tag_id`
  FOREIGN KEY (`tag_id`)
  REFERENCES `tag` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE ,
INDEX `fk-item_tag-item_id-idx` (`item_id` ASC),
CONSTRAINT `fk-item_tag-item_id`
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
  
  static function findById($id, $instance = 'ItemTag') {
    global $mysqli;
    $query = 'SELECT * FROM item_tag WHERE id=' . $id;
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
    $query = "SELECT * FROM item_tag";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new ItemTag();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM item_tag LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new ItemTag();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM item_tag";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE item_tag";
    return $mysqli->query($query);
  }
}