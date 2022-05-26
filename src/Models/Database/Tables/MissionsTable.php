<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Database\Tables\UsersTable;

class MissionsTable extends Tables
{
    protected static $table = 'missions';

    public static function allMissions ()
    {
        return self::find([], null, true);
    }

    public static function allHideouts ()
    {
        $statement['select'] = 'h.id, h.code, h.address, h.type, ctr.country as country';
        $statement['join'] = " as h
            INNER JOIN countries as ctr
            ON h.countryId = ctr.id
            "; 
        return self::find($statement, '_hideouts', true);
    }

    public static function getMission ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
            ];

        return self::find($statement);
    }

    public static function getHideout ($id)
    {
        $statement['select'] = 'h.id, h.code, h.address, h.type, ctr.country as country';
        $statement['join'] = " as h
            INNER JOIN countries as ctr
            ON h.countryId = ctr.id
            ";
        $statement['where'] = 'h.id = ?';
        $statement['att'] = $id;

        return self::find($statement, '_hideouts');
    }

    public static function newMission ($title, $desc, $cName, $cId, $aIds, $cIds, $tIds, $tId, $state, $hIds, $fId, $sDate, $eDate)
    {
        $aIds = implode(',', $aIds);
        $cIds = implode(',', $cIds);
        $tIds = implode(',', $tIds);
        $hIds = implode(',', $hIds);
        
        self::generalAdd([
            'title' => $title,
            'description' => $desc,
            'codeName' => $cName,
            'countryId' => $cId,
            'agentIds' => $aIds,
            'contactIds' => $cIds,
            'targetIds' => $tIds,
            'typeId' => $tId,
            'state' => $state,
            'hideoutIds' => $hIds,
            'facultyId' => $fId,
            'startDate' => $sDate,
            'endDate' => $eDate
            ]);
    }

    public static function newHideout ($code, $address, $countyId, $type)
    {
        self::generalAdd([
            'code' => $code,
            'address' => $address,
            'countryId' => $countyId,
            'type' => $type
            ], '_hideouts');
    }

    public static function editMission ($id, $title, $desc, $cName, $cId, $aIds, $cIds, $tIds, $tId, $state, $hIds, $fId, $sDate, $eDate)
    {
        $aIds = implode(',', $aIds);
        $cIds = implode(',', $cIds);
        $tIds = implode(',', $tIds);
        $hIds = implode(',', $hIds);
        
        self::generalEdit([
            'datas' => [
                'title' => $title,
                'description' => $desc,
                'codeName' => $cName,
                'countryId' => $cId,
                'agentIds' => $aIds,
                'contactIds' => $cIds,
                'targetIds' => $tIds,
                'typeId' => $tId,
                'state' => $state,
                'hideoutIds' => $hIds,
                'facultyId' => $fId,
                'startDate' => $sDate,
                'endDate' => $eDate
                ],
            'ids' => ['id' => $id]
            ]);
    }

    public static function editHideout ($id, $code, $address, $countyId, $type)
    {
        self::generalEdit([
            'datas' => [
                'code' => $code,
                'address' => $address,
                'countryId' => $countyId,
                'type' => $type
                ],
            'ids' => ['id' => $id]
            ], '_hideouts');
    }

    public static function deleteMission ($id)
    {
        self::generalDelete($id);
    }

    public static function deleteHideout ($id)
    {
        self::generalDelete($id, '_hideouts');
    }

    public static function targetAndAgentsMatch ($tId, $aIds)
    {
        $target = UsersTable::getTarget($tId);

        for ($x = 0; $x < count($aIds); $x++) {
            $agent = UsersTable::getAgent($aIds[$x]);
            if ($target->nationality === $agent->nationality) return true;
        }

        return false;
    }

    public static function agentsGotTheFaculty ($fId, $aIds)
    {
        $agentsMatch = [];
        
        for ($x = 0; $x < count($aIds); $x++) {
            $agent = UsersTable::getAgent($aIds[$x]);
            $aFaculties = explode(',', $agent->faculties);
            $agentFaculties = [];

            for ($y = 0; $y < count($aFaculties); $y++):
                $agentFaculties[] = SystemTable::getFaculty($aFaculties[$y])->id;
            endfor;

            if (in_array($fId, $agentFaculties)) $agentsMatch[] = true;
            else $agentsMatch[] = false;
        }

        if (in_array(true, $agentsMatch)) return true;
        return false;
    }
}