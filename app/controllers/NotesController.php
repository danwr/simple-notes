<?php

namespace controllers;

use model\NotePad;

use config\Config;
use utilities\Parsedown;

class NotesController extends Controller
{
    private $notepad;
    private $base_href;
    
    function __construct()
    {
        $this->notepad = new NotePad();
        $config = new Config();
        $this->base_href = $config->value('base_href');
    }

    public function index($get = null)
    {
        // TODO: Restricted access.
        print("NotesController::index\n");
        $notes = $this->notepad->loadAllNotes();
        return $this->renderer()->renderView('IndexPage', array('notes' => $notes, 'base_href' => $this->base_href));
    }
    
    public function delete($get = null)
    {
        // TODO: Restricted access.
        print("NotesController::delete\n");
        if (!is_null($get)) {
            $this->notepad->delete($get['id']);
        }
        return $this->redirect($this->base_href);
    }
    
    public function insert($post = null)
    {
        // TODO: Restricted access.

        $this->notepad->create($post['title'], $post['content'], $post['tags']);
        //return $this->redirect($this->base_href . 'list');
        return true; // temp for easier debuggin
    }
    
    public function edit($get)
    {
        printf("NotesController::edit %s\n", $get['ref']);
        $id = $this->notepad->IDForRef($get['ref']);
        $note = $this->notepad->loadNote($id);
        return $this->renderer()->renderView('EditNotePage', array('note' => $note, 'base_href' => $this->base_href));
    }
    
    public function update($post)
    {
        $this->notepad->edit($post['id'], $post['title'], $post['content'], $post['tags']);
        return $this->redirect($this->base_href);
    }

    public function show($get = null)
    {
        $id = $this->notepad->IDForRef($get['ref']);
        $note = $this->notepad->loadNote($id);
        return $this->renderer()->renderView('NotePage', array('note' => $note, 'base_href' => $this->base_href));
    }
}



?>
