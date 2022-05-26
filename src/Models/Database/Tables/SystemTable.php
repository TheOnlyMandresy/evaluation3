<?php

namespace System\Database\Tables;

use System\Database\Tables;

class SystemTable extends Tables
{
    public static function allCountries ()
    {
        self::$table = 'countries';

        return self::find([], null, true);
    }

    public static function allFaculties ()
    {
        self::$table = 'faculties';

        return self::find([], null, true);
    }

    public static function allMissionsType ()
    {
        self::$table = 'missions_type';

        return self::find([], null, true);
    }

    public static function getCountry ($id)
    {
        self::$table = 'countries';
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;

        return self::find($statement);
    }

    public static function getFaculty ($id)
    {
        self::$table = 'faculties';
        $statement['where'] = 'id = ?';
        $statement['att'] = $id;

        return self::find($statement);
    }

    public static function newCountry ($country, $nationality)
    {
        self::$table = 'countries';
        self::generalAdd([
            'country' => $country,
            'nationality' => $nationality
            ]);
    }

    public static function newFaculty ($name)
    {
        self::$table = 'faculties';
        self::generalAdd( ['name' => $name ]);
    }

    public static function newMissionType ($name)
    {
        self::$table = 'missions_type';
        self::generalAdd( ['name' => $name ]);
    }

    public static function editCountry ($id, $country, $nationality)
    {
        self::$table = 'countries';

        self::generalEdit([
            'datas' => [
                'country' => $country,
                'nationality' => $nationality
                ],
            'ids' => ['id' => $id]
            ]);
    }

    public static function editFaculty ($id, $name)
    {
        self::$table = 'faculties';

        self::generalEdit([
            'datas' => ['name' => $name],
            'ids' => ['id' => $id]
            ]);
    }

    public static function editMissionType ($id, $name)
    {
        self::$table = 'missions_type';

        self::generalEdit([
            'datas' => ['name' => $name],
            'ids' => ['id' => $id]
            ]);
    }

    public static function deleteCountry ($id)
    {
        self::$table = 'countries';
        self::generalDelete($id);
    }

    public static function deleteFaculty ($id)
    {
        self::$table = 'faculties';
        self::generalDelete($id);
    }

    public static function deleteMissionType ($id)
    {
        self::$table = 'missions_type';
        self::generalDelete($id);
    }
}