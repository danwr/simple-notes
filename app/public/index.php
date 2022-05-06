<?php

/**
 * Enables autoloading of classes without includes.
 *
 * This allows you to just spawn new instances of the classes as needed with out include statements
 * everywhere. This is great for larger projects where you're orchestrating a lot of different
 * objects.
 */
require_once dirname(__DIR__) . '/autoload.php';

/**
 * All of your web requests are sent to this index file, and then based on what
 * the URI is, the dispatcher then issues the correct commands to PHP.
 */
require_once dirname(__DIR__) . '/dispatch.php';
?>
