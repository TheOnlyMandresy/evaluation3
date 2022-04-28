<?php

use System\Settings;
use System\Database;
use System\Tools\ErrorTool;

class System extends Settings
{
    private static $db;
    private static $page;

    /**
     * URL processing
     */
    public function __construct ()
    {
        $page = $_SERVER['REQUEST_URI'];

        if (str_contains($page, '?')) return new ErrorTool(404);

        $page = explode('/', $page);
        array_shift($page);
        self::$page = $page;

        return self::page();
    }

    /**
     * Find root path
     * @param int $back : How far we want to go back
     * @return string
     */
    public static function root ($back = 2)
    {
        return realpath( dirname( __FILE__ , $back) ).'/';
    }

    /**
     * Load corresponding page
     */
    private static function page ()
    {
        switch (self::$page[0]) {
            case "":
            case '404':
            case '405':
                $page = 'index';
                break;
            case 'login':
            case 'logout':
                $page = 'users';
                break;
            default:
                $page = self::$page[0];
                break;
        }

        $new = '\System\Controllers\\' .ucfirst($page). 'Controller';
        $controller = new $new(self::$page);
    }

    /**
     * Get settings
     * @param string $name : Constant name
     * @return
     */
    public static function getSystemInfos ($name)
    {
        $load = strtoupper($name);
        $r = new ReflectionClass(__CLASS__);

        return $r->getConstant($load);
    }

    /**
     * Get Database
     */
    public static function getDb ()
    {
        if (self::$db === null) self::$db = new Database(self::DB_NAME, self::DB_HOST, self::DB_USER, self::DB_PASS);
        
        return self::$db;
    }
}