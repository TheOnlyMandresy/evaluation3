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
}