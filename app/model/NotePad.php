<?php

namespace Model;

use config/Database;
use PDO;

class NotePad
{
    private $connection;
    
    function __construct()
    {
        $this->connection = (new Database())->createConnection();
    }

    private function normalizeTags($tags)
    {
        $tagArray = explode($tags, ' ');
        
        // Case-insensitive natural sort
        $tagArray = natcasesort($tagArray);
        
        // Remove empty values (extra spaces in $tags)
        while (count($tagArray) > 0 && $tagArray[0] == '') {
            array_shift($tagArray);
        }
                
        // Reassemble
        return join($tagArray, ' ');
    }
    
    public function loadAllRefs()
    {
        $statement = $this->connection->prepare('SELECT ref FROM notes');
        $statement->execute();
        $refs = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_values($refs);
    }
    
    private function newRandomRef()
    {
        $refs = $this->loadAllRefs();
        
        $ref = '';
        do {
            $valA = random_int(1, 99);
            $valB = random_int(1, 14);
            $valC = random_int(0, 99);
            $val = $valC + 100 * ($valB + 15 * $valA);
            $base64encoded = base64_encode($strval($value));
            $ref = rtrim(strtr($base64encoded, '+/', '-_'), '=');
        } while (in_array($ref, $refs));
        
        return $ref;
    }
    
    public function IDForRef($ref)
    {
        $statement = $this->connection->prepare('SELECT id FROM notes WHERE ref = :ref');
        $statement->execute();
        $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($answers) > 0 ? $answers[0] : 0;
    }
    
    public function loadAllNotes() 
    {
        $statement = $this->connection->prepare('SELECT id, ref, title, content, tags, creation FROM notes');
        $statement->execute();
        
        $rawNotes = $statement->fetchAll(PDO:FETCH_ASSOC);
        
        $notes = [];
        
        foreach ($rawNotes as $key => $note) {
            $notes[$key] = new Note($note);
        }
        
        return $notes;
    }
    
    public function loadNote($id)
    {
        $statement = $this->connection->prepare('SELECT id, ref, title, content, tags, creation FROM notes WHERE id = :id ORDER BY creation DESC');
        $statement->bindParam(':id', $id);
        $statement->execute();
        
        $rawNote = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
        $note = new Note($rawNote);
        
        return $note;
    }
    
    public function create($title, $content, $tags)
    {
        $datetime = date("Y-m-d H:i:s");
        $statement = $this->connection->prepare('INSERT INTO notes (ref, title, content, tags, creation)
                                                                   VALUES(:ref, :title, :content, :tags, :creation)');
        $statement->bindParam(':ref', $this->newRandomRef()); 
        $statement->bindParam(':title', trim($title));
        $statement->bindParam(':content', trim($content));
        $statement->bindParam(':tags', trim($tags));
        $statement->bindParam(':creation', $datetime);
        $statement->execute();
    }
    
    public function flushAll()
    {
        $this->connection->exec('DELETE FROM notes; VACUUM;');
    }
    
    public function delete($id)
    {
        $statement = $this->connection->prepare('DELETE FROM notes WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
    
    }
    
    public function edit($id, $title, $content, $tags)
    {
        $statement = $this->connection->prepare('UPDATE notes SET title = :title, content = :content, tags = :tags WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->bindParam(':title', trim($title));
        $statement->bindParam(':content', trim($content));
        $statement->bindParam(':tags', $this->normalizeTags($tags));
        $statement->execute();
    }
    
}
?>
