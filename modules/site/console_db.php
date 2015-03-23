<?php
  //-- Product:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "site") {
      echo " - Drop table 'product' ";
      echo Product::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Product:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "product") ) {
  //- create tables if not exits
  echo " - Create table 'product' ";
  echo Product::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  
  //-- SubProduct:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "site") {
      echo " - Drop table 'sub_product' ";
      echo SubProduct::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- SubProduct:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "sub_product") ) {
  //- create tables if not exits
  echo " - Create table 'sub_product' ";
  echo SubProduct::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  
  //-- Item:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "site") {
      echo " - Drop table 'item' ";
      echo Item::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Item:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "item") ) {
  //- create tables if not exits
  echo " - Create table 'item' ";
  echo Item::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  
  //-- ItemCategory:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "site") {
      echo " - Drop table 'item_category' ";
      echo ItemCategory::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- ItemCategory:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "item_category") ) {
  //- create tables if not exits
  echo " - Create table 'item_category' ";
  echo ItemCategory::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  