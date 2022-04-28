<?php

namespace System;

use System;

class Controller
{
    protected static $compact = [];

    /**
     * Rendering page
     * @param string $name Page to load
     * @param array $vars
     * @param bool $api Is an api data
     */
    protected static function render ($name, $vars = [], $api = false)
    {
        ob_start();
            extract($vars);
        ob_end_clean();

        if (str_contains($name, '/')) {
            $name = explode('/', $name);
            for ($i = 0; $i < count($name); $i++) {
                $name[$i] = ucfirst($name[$i]);
            }
            $name = implode('/', $name);
        }
        
        require_once System::root(1). 'Views/Pages/' .ucfirst($name). '.php';

        if (!$api) require_once System::root(1). 'Views/Layouts/Base.php';
    }
    
    /**
     * All systems errors
     * @param int $code
     */
    protected static function error ($code)
    {
        switch ($code)
        {
            case 403:
                echo json_encode(403);
                break; 
            case 404:
                echo json_encode(404);
                break; 
            case 405:
                echo json_encode(405);
                break;
        }
    }
    
    /** 
     * Add unexpected datas
     * @param array $array Variables
     * @param bool $delete Start a new list
     * @return array
     */
    protected static function compact ($array = null, $delete = false)
    {
        if ($delete === true) static::$compact = [];

        if ($array !== null) {
            foreach ($array as $var) {
                static::$compact[] = $var;
            }
        }

        return static::$compact;
    }
}