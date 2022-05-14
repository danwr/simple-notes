<?php

namespace model;

use config\Database;
use PDO;

function rand_int_compat($min, $max)
{
    // replace with random_int() in php 7 and later
    return rand($min, $max);
}

class NotePad
{
    private $connection;
    
    function __construct()
    {
	    $db = new Database();
        $this->connection = $db->createConnection();
    }

    private function normalizeTags($tags)
    {
        $tagArray = explode(' ', $tags);
        
        // Case-insensitive natural sort
        natcasesort($tagArray);
        
        // Remove empty values (extra spaces in $tags)
        while (count($tagArray) > 0 && $tagArray[0] == '') {
            array_shift($tagArray);
        }
                
        // Reassemble
        return join(' ', $tagArray);
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
            $valA = rand_int_compat(1, 99);
            $valB = rand_int_compat(1, 14);
            $valC = rand_int_compat(0, 99);
            $val = $valC + 100 * ($valB + 15 * $valA);
            $base64encoded = base64_encode(strval($val));
            $ref = rtrim(strtr($base64encoded, '+/', '-_'), '=');
        } while (in_array($ref, $refs));

        printf("newRandomRef: %s\n", $ref);        
        return $ref;
    }
    
    public function IDForRef($ref)
    {
        $statement = $this->connection->prepare('SELECT id FROM notes WHERE ref = :ref');
        $statement->bindParam(':ref', $ref);
        $statement->execute();
        $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($answers) == 0) {
        	return 0;
        }
        $answer = $answers[0];
        return $answer['id'];
    }
    
    public function loadAllNotes() 
    {
        $statement = $this->connection->prepare('SELECT * FROM notes ORDER BY creation DESC');
        $statement->execute();
        
        $rawNotes = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $notes = array();
        
        foreach ($rawNotes as $key => $note) {
            $notes[$key] = new Note($note);
        }
        
        return $notes;
    }
    
    public function loadNote($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM notes WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        
        $rawNotes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rawNote = $rawNotes[0];
        $note = new Note($rawNote);
        return $note;
    }
    
    public function loadNoteByRef($ref)
    {
    	$id = IDForRef($ref);
    	return loadNote($id);
    }
    
    public function create($title, $content, $tags)
    {
        $datetime = date("Y-m-d H:i:s");
        printf("create: title,content,tags = '%s','%s','%s'\n", $title, $content, $tags);
        $statement = $this->connection->prepare('INSERT INTO notes (ref, title, content, tags, creation, modified)
                                                                   VALUES(:ref, :title, :content, :tags, :creation, :modified)');
        $ref = $this->newRandomRef();
        $statement->bindParam(':ref', $ref); 
        $statement->bindParam(':title', trim($title));
        $statement->bindParam(':content', trim($content));
        $statement->bindParam(':tags', trim($tags));
        $statement->bindParam(':creation', $datetime);
        $statement->bindParam(':modified', $datetime);
        $statement->execute();
        return $ref;
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
        $statement = $this->connection->prepare('UPDATE notes SET title = :title, content = :content, tags = :tags, modified = :modified WHERE id = :id');
        $modified = date("Y-m-d H:i:s");
        $statement->bindParam(':id', $id);
        $statement->bindParam(':title', trim($title));
        $statement->bindParam(':content', trim($content));
        $statement->bindParam(':tags', $this->normalizeTags($tags));
        $statement->bindParam(':modified', $modified);
        $statement->execute();
    }
    
}
?>
