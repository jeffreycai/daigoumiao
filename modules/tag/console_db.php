<?php
  //-- Tag:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "tag") {
      echo " - Drop table 'tag' ";
      echo Tag::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Tag:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "tag") ) {
  //- create tables if not exits
  echo " - Create table 'tag' ";
  echo Tag::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  