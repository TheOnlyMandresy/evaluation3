<?php

namespace System\Controllers;

use System\Database\Tables\SystemTable;
use System\Database\Tables\MissionsTable;
use System\Database\Tables\UsersTable;
use System\Controller;
use System\Tools\DateTool;
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

        $countries = [];
        $allC = SystemTable::allCountries();
        if ($allC) for ($i = 0; $i < count($allC); $i++) $countries[$allC[$i]->id] = $allC[$i]->country;

        $types = [];
        $allMT = SystemTable::allMissionsType();
        if ($allMT) for ($i = 0; $i < count($allMT); $i++) $types[$allMT[$i]->id] = $allMT[$i]->name;

        $all = MissionsTable::allMissions();

        self::render('base/index', compact(self::compact(['all', 'countries', 'types'])));
    }

    private static function notFound ()
    {
        $title = TextTool::setTitle('introuvable');
        $h1 = '404';
        $message = 'Page introuvable.';

        self::render('base/error', compact(static::compact(['h1', 'message'])));
    }

    private static function denied ()
    {
        $title = TextTool::setTitle('accès refuser');
        $h1 = '405';
        $message = 'Accès refusé.';

        self::render('base/error', compact(static::compact(['h1', 'message'])));
    }
}