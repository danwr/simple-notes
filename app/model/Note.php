<?php

namespace Model;

use DateTime;

class Note
{
    private $id;
    private $title;
    private $content;
    private $created_at;
    
    function __construct($row)
    {
        $this->id = $row['id'];
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->created_at = new DateTime($row['created_at']);
    }
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }
    
    public function getBriefTitle()
    {
        return htmlspecialchars(substr($this->title, 0, 15), ENT_QUOTES, 'UTF-8');
    }
    
    public function getContent()
    {
        return htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8');
    }
    
    public function getCreationDateTime()
    {
        return $this->created_at;
    }
}

?>
