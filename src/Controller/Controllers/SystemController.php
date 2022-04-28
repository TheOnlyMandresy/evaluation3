<?php

namespace System\Controllers;

use System;
use System\Database\Tables\SystemTable;
use System\Controller;
use System\Tools\TextTool;

class SystemController extends Controller
{
    function __construct ($page)
    {
        self::compact(['title'], true);
        array_shift($page);

        $load = $page[0];
        self::$load();
    }

    private static function countries ()
    {
        if (isset($_POST['new'])) {
            $country = TextTool::security($_POST['country']);
            $nationality = TextTool::security($_POST['nationality']);
            SystemTable::newCountry($country, $nationality);
        }

        $title = TextTool::setTitle('les pays');
        $all = SystemTable::allCountries();

        self::render('system/countries', compact(self::compact(['all'])));

    }

    private static function faculties ()
    {
        if (isset($_POST['new'])) {
            $name = TextTool::security($_POST['name']);
            SystemTable::newFaculty($name);
        }

        $title = TextTool::setTitle('Facultés d\'agent');
        $all = SystemTable::allFaculties();

        self::render('system/faculties', compact(self::compact(['all'])));
    }

    private static function missions ()
    {
        if (isset($_POST['new'])) {
            $name = TextTool::security($_POST['name']);
            SystemTable::newMissionType($name);
        }

        $title = TextTool::setTitle('types de mission');
        $all = SystemTable::allMissionsType();

        self::render('system/missions', compact(self::compact(['all'])));
    }
}