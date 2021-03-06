<?php

use config\Config;

namespace utilities;

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

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

    private $succeeded;
    
    /**
     * Router constructor.
     */
    function __construct()
    {
        $this->request  = $_SERVER['REQUEST_URI'];
        $this->method   = $_SERVER['REQUEST_METHOD'];
        $config = new \config\Config();
        $base_href = $config->value('base_href');
        if (!is_null($base_href) && $base_href != '' && str_starts_with($this->request, $base_href)) {
	    $this->request = substr($this->request, strlen($base_href));
        }
        $this->succeeded = false;
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
            $class       = 'controllers\\' . $actionParts[0];
            $method      = $actionParts[1];
            $controller  = new $class;

            $controller->{$method}($_GET);
            $this->succeeded = true;
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
            $class       = 'controllers\\' . $actionParts[0];
            $method      = $actionParts[1];
            $controller  = new $class;

            $controller->{$method}($_POST);
            $this->succeeded = true;
        }

        return true;
    }
    
    public function elseFail()
    {
        if (!$this->succeeded) {
            printf("<p>Dispatcher::elseFail ! method = '%s', request = '%s'</p>\n", $this->method, $this->request);
            //http_response_code(400);
        }
    }
    
}
