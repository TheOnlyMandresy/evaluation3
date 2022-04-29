<?php

namespace System\Database\Tables;

use System\Database\Tables;

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
}