<?php

namespace Controllers;

use model\NotePad;

class NotesController extends Controller
{
    private notepad;
    
    function __construct()
    {
        $this->notepad = new NotePad();
    }

    public function index($get = null)
    {
        // TODO: Restricted access.
        $notes = $this->notepad->loadAllNotes();
        return $this->renderer()->renderView('IndexPage', ['notes' => $notes]);
    }
    
    public function delete($get = null)
    {
        // TODO: Restricted access.
        if (!is_null($get)) {
            $this->notepad->delete($get['id']);
        }
        return $this->redirect('/');
    }
    
    public function insert($get = null)
    {
        // TODO: Restricted access.
        $this->notepad->create($post['title'], $post['content'], $post['tags']);
        return $this->redirect('/');
    }
    
    public function edit($post)
    {
        $this->notepad->edit($post['id'], $post['title'], $post['content'], $post['tags']);
        return $this->redirect('/');
    }
    
}



?>
