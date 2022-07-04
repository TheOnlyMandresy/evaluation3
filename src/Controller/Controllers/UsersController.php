<?php

namespace System\Controllers;

use System\Database\Tables\UsersTable;
use System\Database\Tables\AdminTable;
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
        if (isset($_SESSION['admin'])) header('Location: /');
        
        $title = TextTool::setTitle('connexion');

        if (isset($_POST['login'])) {
            $email = TextTool::security($_POST['email']);
            $password = TextTool::security($_POST['password']);
            $id = false;

            $id = AdminTable::login($email, $password);

            if ($id) header('Location: /');
        }

        self::render('users/login', compact(self::compact()));
    }

    private static function logout ()
    {
        if (!isset($_SESSION['admin'])) header('Location: /');
        
        $datas['datas'] = ['identificationId' => null];
        $datas['ids'] = ['identificationId' => $_SESSION['admin']];

        AdminTable::generalEdit($datas);
        unset($_SESSION['admin']);

        header('Location: /');
    }

    private static function agents ()
    {
        if (!isset($_SESSION['admin'])) return ErrorTool::error(405);

        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $userId = TextTool::uniqid();
            $lName = TextTool::security($_POST['lastname']);
            $fName = TextTool::security($_POST['firstname']);
            $bDate = DateTool::dateFormat(TextTool::security($_POST['birth']), 'datetime');
            $cName = TextTool::security($_POST['codeName']);
            $cId = TextTool::security($_POST['nationality']);
            $fIds = (is_array($_POST['faculties'])) ? $_POST['faculties'] : null;

            if (!is_null($fIds)) for ($i = 0; $i < count($fIds); $i++) $fIds[$i] = TextTool::security($fIds[$i]);

            if (isset($_POST['new'])) UsersTable::newAgent($userId, $lName, $fName, $bDate, $cName, $cId, $fIds);

            if (isset($_POST['edit'])) {
                $userId = $_POST['edit'];
                UsersTable::editAgent($userId, $lName, $fName, $bDate, $cName, $cId, $fIds);
            }
        }

        if (isset($_POST['delete'])) UsersTable::deleteAgent($_POST['delete']);

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
        if (!isset($_SESSION['admin'])) return ErrorTool::error(405);

        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $userId = TextTool::uniqid();
            $lName = TextTool::security($_POST['lastname']);
            $fName = TextTool::security($_POST['firstname']);
            $bDate = DateTool::dateFormat(TextTool::security($_POST['birth']), 'datetime');
            $cId = TextTool::security($_POST['nationality']);
            $cName = TextTool::security($_POST['codeName']);

            if (isset($_POST['new'])) UsersTable::newContact($userId, $lName, $fName, $bDate, $cId, $cName);

            if (isset($_POST['edit'])) {
                $userId = $_POST['edit'];
                UsersTable::editContact($userId, $lName, $fName, $bDate, $cId, $cName);
            }
        }

        if (isset($_POST['delete'])) UsersTable::deleteContact($_POST['delete']);

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
        if (!isset($_SESSION['admin'])) return ErrorTool::error(405);

        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $userId = TextTool::uniqid();
            $lName = TextTool::security($_POST['lastname']);
            $fName = TextTool::security($_POST['firstname']);
            $bDate = DateTool::dateFormat(TextTool::security($_POST['birth']), 'datetime');
            $cId = TextTool::security($_POST['nationality']);
            $cName = TextTool::security($_POST['codeName']);

            if (isset($_POST['new'])) UsersTable::newTarget($userId, $lName, $fName, $bDate, $cId, $cName);

            if (isset($_POST['edit'])) {
                $userId = $_POST['edit'];
                UsersTable::editTarget($userId, $lName, $fName, $bDate, $cId, $cName);
            }
        }

        if (isset($_POST['delete'])) UsersTable::deleteTarget($_POST['delete']);

        $title = TextTool::setTitle('les cibles');
        $nationalities = [];
        $all = UsersTable::allTargets();

        $countries = SystemTable::allCountries();
        if ($countries) {
            for ($i = 0; $i < count($countries); $i++) $nationalities[$countries[$i]->id] = $countries[$i]->nationality;
        }

        self::render('users/targets', compact(self::compact(['all', 'nationalities'])));
    }

    private static function password ()
    {        
        if (isset($_POST['generate'])) {
            $password = TextTool::security($_POST['password']);
            $secure = TextTool::security($password, 'convertPass');
            self::compact(['secure']);
        }
        
        $title = TextTool::setTitle('securiseur de mot de passe');

        self::render('users/password', compact(static::compact()));
    }
}