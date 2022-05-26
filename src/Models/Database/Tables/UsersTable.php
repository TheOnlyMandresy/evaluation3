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
                $statement['select'] .= ', agent.codeName as codeName, agent.facultyIds as faculties';
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

    public static function getAgent ($id)
    {
        $statement = self::statement('agents');
        $statement['where'] = 'u.id = ?';
        $statement['att'] = $id;

        return self::find($statement);
    }

    public static function getTarget ($id)
    {
        $statement = self::statement('targets');
        $statement['where'] .= ' AND u.id = ?';
        $statement['att'] = $id;

        return self::find($statement);
    }

    public static function getContact ($id)
    {
        $statement = self::statement('contacts');
        $statement['where'] .= ' AND u.id = ?';
        $statement['att'] = $id;

        return self::find($statement);
    }

    private static function newUser ($userId, $lName, $fName, $bDate, $cId)
    {
        return self::generalAdd([
            'id' => $userId,
            'lastname' => $lName,
            'firstname' => $fName,
            'birthDate' => $bDate,
            'countryId' => $cId
            ]);
    }

    public static function newTarget ($userId, $lName, $fName, $bDate, $cId, $cName)
    {
        self::newUser($userId, $lName, $fName, $bDate, $cId);

        self::generalAdd([
            'userId' => $userId,
            'codeName' => $cName,
            'isTarget' => 1
            ], '_others');
    }

    public static function newContact ($userId, $lName, $fName, $bDate, $cId, $cName)
    {
        self::newUser($userId, $lName, $fName, $bDate, $cId);

        self::generalAdd([
            'userId' => $userId,
            'codeName' => $cName,
            'isTarget' => 0
        ]   , '_others');
    }

    public static function newAgent ($userId, $lName, $fName, $bDate, $cName, $cId, $fIds)
    {
        $fIds = implode(',', $fIds);

        self::newUser($userId, $lName, $fName, $bDate, $cId);

        self::generalAdd([
            'userId' => $userId,
            'codeName' => $cName,
            'facultyIds' => $fIds
            ], '_agents');
    }

    public static function editUser ($userId, $lName, $fName, $bDate, $cId)
    {
        self::generalEdit([
            'datas' => [
                'lastname' => $lName,
                'firstname' => $fName,
                'birthDate' => $bDate,
                'countryId' => $cId
            ],
            'ids' => ['id' => $userId]
            ]);
    }
    
    public static function editAgent ($userId, $lName, $fName, $bDate, $cName, $cId, $fIds)
    {
        $fIds = implode(',', $fIds);

        self::editUser($userId, $lName, $fName, $bDate, $cId);

        $datas['datas'] = [
            'codeName' => $cName,
            'facultyIds' => $fIds
        ];
        $datas['ids'] = ['userId' => $userId];

        self::generalEdit($datas, '_agents');
    }
    
    public static function editTarget ($userId, $lName, $fName, $bDate, $cId, $cName)
    {
        self::editUser($userId, $lName, $fName, $bDate, $cId);

        self::generalEdit([
            'datas' => ['codeName' => $cName],
            'ids' => ['userId' => $userId]
            ], '_others');
    }
    
    public static function editContact ($userId, $lName, $fName, $bDate, $cId, $cName)
    {
        self::editUser($userId, $lName, $fName, $bDate, $cId);

        self::generalEdit([
            'datas' => ['codeName' => $cName],
            'ids' => ['userId' => $userId]
            ], '_others');
    }

    public static function deleteUser ($userId)
    {
        self::generalDelete($userId);
    }

    public static function deleteAgent ($userId)
    {
        self::deleteUser($userId);
        self::generalDelete(['userId', $userId], '_agents');
    }

    public static function deleteTarget ($userId)
    {
        self::deleteUser($userId);
        self::generalDelete(['userId', $userId], '_others');
    }

    public static function deleteContact ($userId)
    {
        self::deleteUser($userId);
        self::generalDelete(['userId', $userId], '_others');
    }
}