<?php

namespace config;

class DBConfiguration
{
  private $sqliteFile;
  
  public function __construct()
  {
      $this->sqliteFile = 'mynotes.sqlite';
  }
  
  public function sqliteFile()
  {
      return $this->$sqliteFile;
  }
}
?>
