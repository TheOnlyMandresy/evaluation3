<?php

namespace System\Controllers;

use System\Controller;
use System\Database\Tables\MissionsTable;
use System\Database\Tables\SystemTable;
use System\Database\Tables\UsersTable;
use System\Tools\DateTool;
use System\Tools\TextTool;

class MissionsController extends Controller
{
    function __construct ($page)
    {
        self::compact(['title'], true);
        array_shift($page);

        $load = $page[0];
        self::$load();
    }

    private static function new ()
    {
        if (isset($_POST['new']))
        {
            $title = TextTool::security($_POST['title']);
            $desc = TextTool::security($_POST['description']);
            $cName = TextTool::security($_POST['codeName']);
            $cId = TextTool::security($_POST['country']);
            $aIds = TextTool::security($_POST['agents']);
            $cIds = TextTool::security($_POST['contacts']);
            $tIds = TextTool::security($_POST['targets']);
            $tId = TextTool::security($_POST['type']);
            $state = TextTool::security($_POST['state']);
            $hIds = TextTool::security($_POST['hideouts']);
            $fId = TextTool::security($_POST['faculty']);
            $sDate = TextTool::security($_POST['startDate']);
            $eDate = TextTool::security($_POST['endDate']);
        }

        $title = TextTool::setTitle('les missions');
        
        $countries = [];
        $allC = SystemTable::allCountries();
        if ($allC) for ($i = 0; $i < count($allC); $i++) $countries[$allC[$i]->id] = $allC[$i]->country;

        $types = [];
        $allMT = SystemTable::allMissionsType();
        if ($allMT) for ($i = 0; $i < count($allMT); $i++) $types[$allMT[$i]->id] = $allMT[$i]->name;

        $faculties = [];
        $allF = SystemTable::allFaculties();
        if ($allF) for ($i = 0; $i < count($allF); $i++) $hideouts[$allF[$i]->id] = $allF[$i]->name;

        $agents = [];
        $allA = UsersTable::allAgents();
        if ($allA) for ($i = 0; $i < count($allA); $i++) $agents[$allA[$i]->id] = $allA[$i]->lastname. ' ' .$allA[$i]->firstname. ' ' .DateTool::dateFormat($allA[$i]->birthDate, 'd/m/y');

        $contacts = [];
        $allC = UsersTable::allContacts();
        if ($allC) for ($i = 0; $i < count($allC); $i++) $contacts[$allC[$i]->id] = $allC[$i]->codeName;

        $targets = [];
        $allT = UsersTable::allTargets();
        if ($allT) for ($i = 0; $i < count($allT); $i++) $targets[$allT[$i]->id] = $allT[$i]->codeName;

        $hideouts = [];
        $allH = MissionsTable::allHideouts();
        if ($allH) for ($i = 0; $i < count($allH); $i++) $hideouts[$allH[$i]->id] = $allH[$i]->code. ' (' .$allH[$i]->address. ')';

        $all = MissionsTable::allMissions();

        self::render('missions/all', compact(self::compact(['all', 'countries', 'types', 'faculties', 'agents', 'contacts', 'targets', 'hideouts'])));
    }

    private static function hideouts ()
    {
        if (isset($_POST['new'])) {
            $code = TextTool::security($_POST['code']);
            $address = TextTool::security($_POST['address']);
            $countryId = TextTool::security($_POST['country']);
            $type = TextTool::security($_POST['type']);

            MissionsTable::newHideout($code, $address, $countryId, $type);
        }

        $title = TextTool::setTitle('les planques');
        $countries = [];

        $allC = SystemTable::allCountries();
        if ($allC) for ($i = 0; $i < count($allC); $i++) $countries[$i+1] = $allC[$i]->country;

        $all = MissionsTable::allHideouts();

        self::render('missions/hideouts', compact(self::compact(['all', 'countries'])));
    }
}