<?php

namespace controllers;

use model\NotePad;

use config\Config;

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
    
    public function insert($get = null)
    {
        // TODO: Restricted access.
        print("NotesController::insert\n");
        $this->notepad->create($post['title'], $post['content'], $post['tags']);
        return $this->redirect($this->base_href);
    }
    
    public function edit($post)
    {
        print("NotesController::edit\n");
        $this->notepad->edit($post['id'], $post['title'], $post['content'], $post['tags']);
        return $this->redirect($this->base_href);
    }

	public function show($get = null)
	{
	    print("NotesController::show\n");
	    $id = $this->notepad->IDForRef($get['ref']);
	    $note = $this->notepad->loadNote($id);
	    printf("show. ref = '%s'\n", $get['ref']);
	    var_dump($note);
	    return $this->renderer()->renderView('NotePage', array('note' => $note));
	}    
}



?>
