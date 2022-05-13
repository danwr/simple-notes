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
        $notes = $this->notepad->loadAllNotes();
        $options = array('notes' => $notes, 'base_href' => $this->base_href);
        $tag = $get['tag'];
        if (!is_null($tag)) {
            $options['tag'] = $tag;
            $matches = array();
            foreach ($notes as $note) {
               if ($note->hasTag($tag)) {
                   array_push($matches, $note);
               }
            }
            $options['notes'] = $matches;
        }
        return $this->renderer()->renderView('IndexPage', $options);
    }
    
    public function delete($get = null)
    {
        // Restricted access.
        print("NotesController::delete\n");
        if (!is_null($get)) {
            $id = $this->notepad->IDForRef($ref);
            if (!is_null($id)) {
                $this->notepad->delete($id);
            }
        }
        return $this->redirect($this->base_href);
    }
    
    public function insert($post = null)
    {
        // Restricted access.
        $ref = $this->notepad->create($post['title'], $post['content'], $post['tags']);
        if (!is_null($ref)) {
            return $this->redirect($this->base_href . 'note/?ref=' . $ref);
        }
        return $this->redirect($this->base_href . 'list/');
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
        $id = $post['id'];
        $note = $this->notepad->loadNote($id);
        $this->renderer()->renderView('NotePage', array('note' => $note, 'base_href' => $this->base_href));  
        //return $this->redirect($this->base_href . 'list/');
    }

    public function show($get = null)
    {
        $id = $this->notepad->IDForRef($get['ref']);
        $note = $this->notepad->loadNote($id);
        return $this->renderer()->renderView('NotePage', array('note' => $note, 'base_href' => $this->base_href));
    }
}



?>
