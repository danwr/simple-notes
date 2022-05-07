<?php

/**
 * Class Autoloader
 */
class Autoloader
{
    /**
     * Loads the classes as called.
     *
     * @param $class
     * @return bool
     */
    public static function loader($class)
    {
        $file = dirname(__DIR__) . '/app/' . str_replace('\\', '/', $class) . '.php';
	printf("file is '%s'\n", $file);
        if (file_exists($file)) {
            include $file;

            if (class_exists($class)) {
                return true;
            }
        }

        return false;
    }
}

/**
 * Registers the autoloader for the application.
 */
spl_autoload_register('Autoloader::loader');
