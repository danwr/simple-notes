<?php

namespace Utilities;

/**
 * Class Dispatcher
 *
 * @package Utilities
 */
class Dispatcher
{
    /**
     * @var string
     */
    private $request;

    /**
     * @var string
     */
    private $method;

    /**
     * Router constructor.
     */
    function __construct()
    {
        $this->request  = $_SERVER['REQUEST_URI'];
        $this->method   = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Renders a GET request to a controller method
     *
     * @param $path
     * @param $action
     * @return bool
     */
    public function dispatchGET($path, $action)
    {
        if ($this->method !== 'GET') {
            return false;
        }

        if (strpos($this->request, '?')) {
            $request       = explode('?', $this->request);
            $this->request = $request[0];
        }

        if ($path === $this->request) {
            $actionParts = explode('#', $action);
            $class       = '\Controllers\\' . $actionParts[0];
            $method      = $actionParts[1];
            $controller  = new $class;

            $controller->{$method}($_GET);
        }

        return true;
    }

    /**
     * Renders a POST Request to a controller method
     *
     * @param $path
     * @param $action
     * @return bool
     */
    public function dispatchPOST($path, $action)
    {
        if ($this->method !== 'POST') {
            return false;
        }

        if ($path === $this->request) {
            $actionParts = explode('#', $action);
            $class       = '\Controllers\\' . $actionParts[0];
            $method      = $actionParts[1];
            $controller  = new $class;

            $controller->{$method}($_POST);
        }

        return true;
    }
}
