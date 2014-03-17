<?php

class Account {

  function __construct ( $account = false) {}
}

class Quartz {

  function __construct () {

    // makes sure they are using the correct version of php
    if( version_compare(PHP_VERSION, '5.3.1', '<') ){
      die('Please upgrade your version of PHP to 5.3.1 or higher.');
    }

    session_start ();

  }
}
?>