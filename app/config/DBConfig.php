<?php

namespace config;

class DBConfig
{
  private $sqliteFile;
  
  public function __construct()
  {
      $this->sqliteFile = 'mynotes_development.sqlite';
  }
  
  public function sqliteFile()
  {
      return $this->sqliteFile;
  }
}
?>
