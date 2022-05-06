<?php

namespace Utilities;

/**
 * Class Renderer
 */
class Renderer
{
    private $viewDir;

    /**
     * Renderer constructor.
     */
    function __construct()
    {
        $this->viewDir = dirname(__DIR__) . '/Views/';
    }

    /**
     * This renders a view and then returns its contents
     *
     * @param $view
     * @param $args
     * @return string
     */
    public function renderView($view, $args)
    {
        ob_start();
        require_once $this->viewDir . $view . '.php';
        ob_end_flush();
    }
}
?>
