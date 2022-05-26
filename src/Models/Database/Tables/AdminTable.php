<?php

namespace System\Database\Tables;

use System\Database\Tables;
use System\Database\Tables\UsersTable;
use System\Tools\TextTool;

class AdminTable extends Tables
{
    protected static $table = 'users_admins';

    public static function getAdmin ($email)
    {
        $statement['where'] = 'email = ?';
        $statement['att'] = $email;

        return self::find($statement);
    }

    public static function login ($emailOrDate, $password)
    {
        $logged = false;

        $user = self::getAdmin($emailOrDate);

        if (password_verify($password, $user->password)) $logged = true;

        if ($logged) {
            $identification = TextTool::uniqid();
    
            $datas['datas'] = ['identificationId' => $identification];
            $datas['ids'] = ['id' => $user->id];
            
            self::generalEdit($datas);
            
            $_SESSION['user'] = $identification;
    
            return $identification;
        }

        return false;
    }
}