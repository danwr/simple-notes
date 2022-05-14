<?php

namespace tools;

use config\Database;

class CreateNotesTable
{
    private $connection;
    
    function __construct()
    {
        $this->connection = (new Database())->createConnection();
    }
    
    public function create()
    {
        $this->connection->exec('CREATE TABLE IF NOT EXISTS notes (
                id      INTEGER PRIMARY KEY AUTOINCREMENT,
                ref     TEXT KEY NOT NULL,
                title   TEXT NOT NULL,
                content TEXT NOT NULL,
                tags    TEXT NOT NULL,
                creation DATETIME NOT NULL,
                modified DATETIME
                );');
    }
    
    public function drop()
    {
        $this->connection->exec('DROP TABLE IF EXISTS notes;');
    }
}

?>
