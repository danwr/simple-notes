<?php

namespace controllers;

use data/Notes;

class NotesController extends Controller
{
    private $notes;
    
    function __construct()
    {
        $this->notes = new Notes();
    }

    public function index($get = null)
    {
        // TODO: list of notes. Restricted access.
    }
    
    public function delete($get = null)
    {
        // TODO: delete note. Restricted access.
    }
    
    public function insert($get = null)
    {
        // TODO: create note. Restricted access.
    }
    
    public function edit($post)
    {
        $this->notes->edit($post['id'], $post['title'], $post['content'], $post['tags']);
        return $this->redirect('/');
    }
    
}



?>
