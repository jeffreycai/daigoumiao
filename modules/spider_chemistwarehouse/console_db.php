<?php
  //-- CwUrlList:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "spider_chemistwarehouse") {
      echo " - Drop table 'cw_url_list' ";
      echo CwUrlList::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- CwUrlList:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "cw_url_list") ) {
  //- create tables if not exits
  echo " - Create table 'cw_url_list' ";
  echo CwUrlList::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  