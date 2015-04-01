<?php
  //-- Vendor:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "vendor") {
      echo " - Drop table 'vendor' ";
      echo Vendor::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Vendor:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "vendor") ) {
  //- create tables if not exits
  echo " - Create table 'vendor' ";
  echo Vendor::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  