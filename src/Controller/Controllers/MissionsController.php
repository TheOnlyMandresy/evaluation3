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

    private static function all ()
    {
        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $setDatas = true;
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

            if (!is_null($aIds)) for ($x = 0; $x < count($aIds); $x++) $aIds[$x] = TextTool::security($aIds[$x]);
            if (!is_null($cIds)) for ($x = 0; $x < count($cIds); $x++) $cIds[$x] = TextTool::security($cIds[$x]);
            if (!is_null($tIds)) for ($x = 0; $x < count($tIds); $x++) $tIds[$x] = TextTool::security($tIds[$x]);
            if (!is_null($hIds)) for ($x = 0; $x < count($hIds); $x++) $hIds[$x] = TextTool::security($hIds[$x]);

            if (!is_null($aIds) and !is_null(($tIds))) {
            for ($x = 0; $x < count($tIds); $x++):
                if (MissionsTable::targetAndAgentsMatch($tIds[$x], $aIds)) {
                    self::flash('Les agents ne peuvent pas être de la même nationalité que les cibles.', 'danger');
                    $setDatas = false;
                }
            endfor;
            }
            
            if (!is_null($cIds)) {
            for ($x = 0; $x < count($cIds); $x++):
                $country = SystemTable::getCountry($cId);
                $contact = UsersTable::getContact($cIds[$x]);
                
                if ($contact->nationality !== $country->nationality) {
                    self::flash('Les contacts doivent être de la même nationalité que le pays où se déroule la mission.', 'danger');
                    $setDatas = false;
                }
            endfor;
            }
            
            if (!is_null($hIds)) {
            for ($x = 0; $x < count($hIds); $x++):
                $country = SystemTable::getCountry($cId);
                $hidehout = MissionsTable::getHideout($hIds[$x]);
                
                if ($hidehout->country !== $country->country) {
                    self::flash('Les planques doivent être dans le même pays que celui où se déroule la mission.', 'danger');
                    $setDatas = false;
                }
            endfor;
            }

            if (!is_null($aIds)) {
                if (!MissionsTable::agentsGotTheFaculty($fId, $aIds)) {
                    self::flash('Au moins un agent doit posséder la spécialité requise pour la mission.', 'danger');
                    $setDatas = false;
                }
            }
            
            if ($setDatas) {
                if (isset($_POST['new'])) MissionsTable::newMission($title, $desc, $cName, $cId, $aIds, $cIds, $tIds, $tId, $state, $hIds, $fId, $sDate, $eDate);
                
                if (isset($_POST['edit'])) {
                    $id = intval($_POST['edit']);
                    MissionsTable::editMission($id, $title, $desc, $cName, $cId, $aIds, $cIds, $tIds, $tId, $state, $hIds, $fId, $sDate, $eDate);
                }
            }

            unset($_POST['edit'], $_POST['new']);
        }

        if (isset($_POST['delete'])) {
            $id = intval($_POST['delete']);
            MissionsTable::deleteMission($id);
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
        if (isset($_POST['new']) || isset($_POST['edit'])) {
            $code = TextTool::security($_POST['code']);
            $address = TextTool::security($_POST['address']);
            $countryId = TextTool::security($_POST['country']);
            $type = TextTool::security($_POST['type']);

            if (isset($_POST['new'])) MissionsTable::newHideout($code, $address, $countryId, $type);

            if (isset($_POST['edit'])) {
                $id = intval($_POST['edit']);
                MissionsTable::editHideout($id, $code, $address, $countryId, $type);
            }
        }

        if (isset($_POST['delete'])) {
            $id = intval($_POST['delete']);
            MissionsTable::deleteHideout($id);
        }

        $title = TextTool::setTitle('les planques');
        $countries = [];

        $allC = SystemTable::allCountries();
        if ($allC) for ($i = 0; $i < count($allC); $i++) $countries[$i+1] = $allC[$i]->country;

        $all = MissionsTable::allHideouts();

        self::render('missions/hideouts', compact(self::compact(['all', 'countries'])));
    }
}