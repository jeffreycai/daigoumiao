<?php
  //-- Brand:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "brand") {
      echo " - Drop table 'brand' ";
      echo Brand::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Brand:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "brand") ) {
  //- create tables if not exits
  echo " - Create table 'brand' ";
  echo Brand::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  