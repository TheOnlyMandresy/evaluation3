<?php

namespace System\Controllers;

use Error;
use System\Controller;
use System\Tools\ErrorTool;
use System\Tools\TextTool;

class UsersController extends Controller
{
    function __construct($page)
    {
        static::compact(['title'], true);

        switch ($page[0]) {
            case 'login':
                return self::index();
            case 'logout':
                return self::logout();
        }
    }

    private static function index ()
    {
        $title = TextTool::setTitle('connexion');

        self::render('users/login', compact(static::$compact));
    }

    private static function logout ()
    {
        $title = TextTool::setTitle('deconnexion');

        self::render('index', compact(static::$compact));
    }
}