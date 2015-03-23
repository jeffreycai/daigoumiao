<?php
  //-- Category:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "category") {
      echo " - Drop table 'category' ";
      echo Category::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Category:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "category") ) {
  //- create tables if not exits
  echo " - Create table 'category' ";
  echo Category::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  