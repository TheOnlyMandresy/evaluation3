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
            $aIds = (is_array($_POST['agents'])) ? $_POST['agents'] : null;
            $cIds = (is_array($_POST['contacts'])) ? $_POST['contacts'] : null;
            $tIds = (is_array($_POST['targets'])) ? $_POST['targets'] : null;
            $tId = TextTool::security($_POST['type']);
            $state = TextTool::security($_POST['state']);
            $hIds = (is_array($_POST['hideouts'])) ? $_POST['hideouts'] : null;
            $fId = TextTool::security($_POST['faculty']);
            $sDate = TextTool::security($_POST['startDate']);
            $eDate = TextTool::security($_POST['endDate']);

            if (!is_null($aIds)) for ($i = 0; $i < count($aIds); $i++) $aIds[$i] = TextTool::security($aIds[$i]);
            if (!is_null($cIds)) for ($i = 0; $i < count($cIds); $i++) $cIds[$i] = TextTool::security($cIds[$i]);
            if (!is_null($tIds)) for ($i = 0; $i < count($tIds); $i++) $tIds[$i] = TextTool::security($tIds[$i]);
            if (!is_null($hIds)) for ($i = 0; $i < count($hIds); $i++) $hIds[$i] = TextTool::security($hIds[$i]);

            MissionsTable::newMission($title, $desc, $cName, $cId, $aIds, $cIds, $tIds, $tId, $state, $hIds, $fId, $sDate, $eDate);
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
        if ($allF) for ($i = 0; $i < count($allF); $i++) $faculties[$allF[$i]->id] = $allF[$i]->name;

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
        if ($all) {
        for ($i = 0; $i < count($all); $i++):
            $all[$i]->agentIds = explode(',', $all[$i]->agentIds);
            $all[$i]->contactIds = explode(',', $all[$i]->contactIds);
            $all[$i]->targetIds = explode(',', $all[$i]->targetIds);
            $all[$i]->hideoutIds = explode(',', $all[$i]->hideoutIds);    
        endfor;
        }

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