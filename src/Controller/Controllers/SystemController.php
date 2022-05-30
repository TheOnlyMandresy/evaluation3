<?php

namespace System\Controllers;

use System\Database\Tables\SystemTable;
use System\Controller;
use System\Tools\TextTool;
use System\Tools\ErrorTool;

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
        if (!isset($_SESSION['admin'])) return ErrorTool::error(405);

        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $country = TextTool::security($_POST['country']);
            $nationality = TextTool::security($_POST['nationality']);
            
            if (isset($_POST['new'])) SystemTable::newCountry($country, $nationality);

            if (isset($_POST['edit'])) {
                $id = intval($_POST['edit']);
                SystemTable::editCountry($id, $country, $nationality);
            }
        }

        if (isset($_POST['delete'])) {
            $id = intval($_POST['delete']);
            SystemTable::deleteCountry($id);
        }

        $title = TextTool::setTitle('les pays');
        $all = SystemTable::allCountries();

        self::render('system/countries', compact(self::compact(['all'])));

    }

    private static function faculties ()
    {
        if (!isset($_SESSION['admin'])) return ErrorTool::error(405);

        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $name = TextTool::security($_POST['name']);
            
            if (isset($_POST['new'])) SystemTable::newFaculty($name);

            if (isset($_POST['edit'])) {
                $id = intval($_POST['edit']);
                SystemTable::editFaculty($id, $name);
            }
        }

        if (isset($_POST['delete'])) {
            $id = intval($_POST['delete']);
            SystemTable::deleteFaculty($id);
        }

        $title = TextTool::setTitle('Facultés d\'agent');
        $all = SystemTable::allFaculties();

        self::render('system/faculties', compact(self::compact(['all'])));
    }

    private static function missions ()
    {
        if (!isset($_SESSION['admin'])) return ErrorTool::error(405);

        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $name = TextTool::security($_POST['name']);
            
            if (isset($_POST['new'])) SystemTable::newMissionType($name);

            if (isset($_POST['edit'])) {
                $id = intval($_POST['edit']);
                SystemTable::editMissionType($id, $name);
            }
        }

        if (isset($_POST['delete'])) {
            $id = intval($_POST['delete']);
            SystemTable::deleteMissionType($id);
        }

        $title = TextTool::setTitle('types de mission');
        $all = SystemTable::allMissionsType();

        self::render('system/missions', compact(self::compact(['all'])));
    }
}