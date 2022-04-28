<?php

namespace System\Database\Tables;

use System\Database\Tables;

class UsersTable extends Tables
{
    protected static $table = 'users';

    /**
     * Auto-fill requests
     * @param string $type Type of the datas searched
     * @return array
     */
    private static function statement ($type)
    {
        $statement = [
            'select' => "
                u.*,
                country.nationality as nationality
            ",
            'join' => " as u
                INNER JOIN countries as country
                ON u.countryId = country.id
            "
        ];

        switch ($type) {
            case 'targets':
                $statement['select'] .= ', target.codeName as codeName';
                $statement['join'] .= ' INNER JOIN users_others as target ON u.id = target.userId';
                $statement['where'] = 'target.isTarget = 1';
                break;
            case 'contacts':
                $statement['select'] .= ', contact.codeName as codeName';
                $statement['join'] .= ' INNER JOIN users_others as contact ON u.id = contact.userId';
                $statement['where'] = 'contact.isTarget = 0';
                break;
            case 'agents':
                $statement['select'] .= ', agent.facultyIds as faculties';
                $statement['join'] .= ' INNER JOIN users_agents as agent ON u.id = agent.userId';
                break;
        }

        return $statement;
    }

    public static function allAgents ()
    {
        return self::find(self::statement('agents'), null, true);
    }

    public static function allTargets ()
    {
        return self::find(self::statement('targets'), null, true);
    }

    public static function allContacts ()
    {
        return self::find(self::statement('contacts'), null, true);
    }

    private static function newUser ($id, $lName, $fName, $bDate, $cId)
    {
        return self::generalAdd([
            'id' => $id,
            'lastname' => $lName,
            'firstname' => $fName,
            'birthDate' => $bDate,
            'countryId' => $cId
        ]);
    }

    public static function newTarget ($id, $lName, $fName, $bDate, $cId, $cName)
    {
        self::newUser($id, $lName, $fName, $bDate, $cId);

        self::generalAdd([
            'userId' => $id,
            'codeName' => $cName,
            'isTarget' => 1
        ], '_others');
    }

    public static function newContact ($id, $lName, $fName, $bDate, $cId, $cName)
    {
        self::newUser($id, $lName, $fName, $bDate, $cId);

        self::generalAdd([
            'userId' => $id,
            'codeName' => $cName,
            'isTarget' => 0
        ], '_others');
    }

    public static function newAgent ($id, $lName, $fName, $bDate, $cId, $pass, $fIds)
    {
        self::newUser($id, $lName, $fName, $bDate, $cId);

        self::generalAdd([
            'userId' => $id,
            'password' => $pass,
            'facultyIds' => $fIds
        ], '_agents');
    }
}