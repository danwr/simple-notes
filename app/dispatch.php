<?php

use utilities\Dispatcher;

$dispatcher = new Dispatcher();

$dispatcher->dispatchGET('/list', 'NotesController#index');
$dispatcher->dispatchGET('/delete', 'NotesController#delete');
$dispatcher->dispatchGET('/new', 'NotesController#insert');
$dispatcher->dispatchGET('/edit', 'NotesController#edit');

?>
