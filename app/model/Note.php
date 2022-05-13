<?php

namespace model;

use DateTime;
use utilities\Parsedown;

class Note
{
    private $id;
    private $ref;
    private $title;
    private $content;
    private $tags;
    private $creation;
    
    function __construct($row)
    {
        $this->id = $row['id'];
        $this->ref = $row['ref'];
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->tags = $row['tags'];
        $this->creation = new DateTime($row['creation']);
    }
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getRef()
    {
        return $this->ref;
    }
    
    public function getTitle()
    {
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }
    
    public function getBriefTitle()
    {
    	if (strlen($this->title) < 18) {
    		return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    	}
        return htmlspecialchars(substr($this->title, 0, 18), ENT_QUOTES, 'UTF-8') . '&hellip;';
    }
    
    public function getContent()
    {
        return htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8');
    }
    
    public function getContentAsHTML()
    {
    	$parsedown = new Parsedown();
    	return $parsedown->text($this->content);
    }
    
    public function getTags()
    {
        return $this->tags;
    }

    public function getCreationDateTime()
    {
        return $this->creation;
    }
}

?>
