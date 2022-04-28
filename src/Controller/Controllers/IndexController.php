<?php

namespace System\Controllers;

use System\Controller;
use System\Tools\TextTool;

class IndexController extends Controller
{
    function __construct($page)
    {
        static::compact(['title'], true);

        switch ($page[0]) {
            case '404':
                return self::notFound();
            case '405':
                return self::denied();
            default:
                return self::index();
        }
    }

    private static function index ()
    {
        $title = TextTool::setTitle('accueil');

        self::render('index', compact(static::$compact));
    }

    private static function notFound ()
    {
        $title = TextTool::setTitle('introuvable');
        $h1 = '404';

        self::render('error', compact(static::compact(['h1'])));
    }

    private static function denied ()
    {
        $title = TextTool::setTitle('accès refuser');
        $h1 = '405';

        self::render('error', compact(static::compact(['h1'])));
    }
}