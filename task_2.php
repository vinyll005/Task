<?php

//                TASK #2

class Db
{
    public static function getDbConnection()
    {
        $db = mysqli_connect('localhost', 'root', '', 'shop');
        return $db;
    }
}

function selectUsersByObjectId()  
{
    $db = Db::getDbConnection();

    $request = $db->query("SELECT * FROM users INNER JOIN objects ON users.object_id = objects.id");
    $users = $request->fetch_assoc();

    return $users;
}

?>