<?php

namespace config;

use PDO;

class Database
{
    private $config;
    
    private $dsn;
    
    function __construct()
    {
        $this->config = new DBConfig();
        $this->dsn    = 'sqlite:' . dirname(__DIR__) . $this->config->sqliteFile();
    }
    
    public function createConnection()
    {
        $pdo = new PDO($this->dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }
}

?>
