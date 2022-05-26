<?php

namespace System;

use System;

class Controller
{
    protected static $compact = [];

    /**
     * Rendu de page
     * @param string $name Page à charger
     * @param array $vars
     * @param bool $api Est-ce une API
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
        require_once System::root(1). 'Views/Layouts/Base.php';
        unset($_SESSION['flash']);
    }
    
    /**
     * Toutes les erreurs du system
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
     * Ajout de données
     * @param array $array Variables
     * @param bool $delete Commencer une nouvelle liste
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

    protected static function flash ($message, $type)
    {
        $_SESSION['flash']['message'] = $message;
        $_SESSION['flash']['type'] = $type;
    }
}