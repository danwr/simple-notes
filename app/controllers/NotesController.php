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
    
    public function delete()
    {
        // TODO: delete note. Restricted access.
    }
    
    public function insert()
    {
        // TODO: create note. Restricted access.
    }
    
    public function edit()
    {
        // TODO: edit note. Restricted access.
    }
    
}



?>
