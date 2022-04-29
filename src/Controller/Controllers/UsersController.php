<?php

namespace System\Controllers;

use System\Database\Tables\UsersTable;
use System\Database\Tables\SystemTable;
use System\Controller;
use System\Tools\DateTool;
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
            default:
                $load = $page[1];
                return self::$load();
        }
    }

    private static function index ()
    {
        $title = TextTool::setTitle('connexion');

        $agents = UsersTable::allContacts();

        self::render('users/login', compact(static::compact(['agents'])));
    }

    private static function logout ()
    {
        $title = TextTool::setTitle('deconnexion');

        self::render('index', compact(static::$compact));
    }

    private static function agents ()
    {
        if (isset($_POST['new'])) {
            $id = TextTool::uniqid();
            $lName = TextTool::security($_POST['lastname']);
            $fName = TextTool::security($_POST['firstname']);
            $bDate = DateTool::dateFormat(TextTool::security($_POST['birthday']), 'datetime');
            $cId = TextTool::security($_POST['nationality']);
            $pass = TextTool::security($_POST['password']);
            $fIds = (is_array($_POST['faculties'])) ? $_POST['faculties'] : null;

            $pass = TextTool::security($pass, 'convertPass');
            if (!is_null($fIds)) for ($i = 0; $i < count($fIds); $i++) $fIds[$i] = TextTool::security($fIds[$i]);

            UsersTable::newAgent($id, $lName, $fName, $bDate, $cId, $pass, $fIds);
        }

        $title = TextTool::setTitle('les agents');
    
        $faculties = [];
        $allF = SystemTable::allFaculties();
        if ($allF) for ($i = 0; $i < count($allF); $i++) $faculties[$allF[$i]->id] = $allF[$i]->name;

        $nationalities = [];
        $countries = SystemTable::allCountries();
        if ($countries) {
            for ($i = 0; $i < count($countries); $i++) $nationalities[$countries[$i]->id] = $countries[$i]->nationality;
        }

        $all = UsersTable::allAgents();
        if ($all) for ($i = 0; $i < count($all); $i++) $all[$i]->faculties = explode(',', $all[$i]->faculties);

        self::render('users/agents', compact(self::compact(['all', 'faculties', 'nationalities'])));
    }

    private static function contacts ()
    {
        if (isset($_POST['newContact'])) {
            $id = TextTool::uniqid();
            $lName = TextTool::security($_POST['lastname']);
            $fName = TextTool::security($_POST['firstname']);
            $bDate = DateTool::dateFormat(TextTool::security($_POST['birthday']), 'datetime');
            $cId = TextTool::security($_POST['nationality']);
            $cName = TextTool::security($_POST['codeName']);

            UsersTable::newContact($id, $lName, $fName, $bDate, $cId, $cName);
        }

        $title = TextTool::setTitle('les contacts');
        $nationalities = [];
        $all = UsersTable::allContacts();

        $countries = SystemTable::allCountries();
        if ($countries) {
            for ($i = 0; $i < count($countries); $i++) $nationalities[$countries[$i]->id] = $countries[$i]->nationality;
        }

        self::render('users/contacts', compact(self::compact(['all', 'nationalities'])));
    }

    private static function targets ()
    {
        if (isset($_POST['newTarget'])) {
            $id = TextTool::uniqid();
            $lName = TextTool::security($_POST['lastname']);
            $fName = TextTool::security($_POST['firstname']);
            $bDate = DateTool::dateFormat(TextTool::security($_POST['birthday']), 'datetime');
            $cId = TextTool::security($_POST['nationality']);
            $cName = TextTool::security($_POST['codeName']);

            UsersTable::newTarget($id, $lName, $fName, $bDate, $cId, $cName);
        }

        $title = TextTool::setTitle('les cibles');
        $nationalities = [];
        $all = UsersTable::allTargets();

        $countries = SystemTable::allCountries();
        if ($countries) {
            for ($i = 0; $i < count($countries); $i++) $nationalities[$countries[$i]->id] = $countries[$i]->nationality;
        }

        self::render('users/targets', compact(self::compact(['all', 'nationalities'])));
    }
}