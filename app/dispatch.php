<?php

use utilities\Dispatcher;
use config\Config;

$config = new Config();

$dispatcher = new Dispatcher();

$dispatcher->dispatchGET('/', 'NotesController#index');
$dispatcher->dispatchGET('list/', 'NotesController#index');
$dispatcher->dispatchGET('delete/', 'NotesController#delete');
$dispatcher->dispatchPOST('new/', 'NotesController#insert');
$dispatcher->dispatchGET('edit/', 'NotesController#edit');

$dispatcher->dispatchGET('note/', 'NotesController#show');
$dispatcher->dispatchPOST('update/', 'NotesController#update');

$dispatcher->elseFail();

?>
