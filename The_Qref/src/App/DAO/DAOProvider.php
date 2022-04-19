<?php

namespace App\Dao;

use DB\DBDAO;

class DAOProvider
{

    private static DAO $dao;

    public static function get()
    {
        if (!isset(self::$dao))
            self::$dao = new DBDAO();
        return self::$dao;
    }
}

