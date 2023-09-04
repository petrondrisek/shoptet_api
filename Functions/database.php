<?php

if(!defined(MySQL_SERVER)) {
   if(file_exists("settings.php")) include ("settings.php");
   else if(file_exists("../settings.php")) include ("../settings.php");
   else throw new Exception("Nepovedlo se připojit settings.php z database.php");
}


/*eshopID: id eshopu int, type: rozliseni na vice API v jedne tabulce*/
function findEshop(int $eshopId, string $type)
{
    $database = new PDO('mysql:dbname='.MySQL_DB.';host='.MySQL_SERVER.';port=3306;charset=utf8', MySQL_USER, MySQL_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $database->prepare("SELECT * FROM `shoptet_api` WHERE `eshopId`=? AND `addon`=? AND `active`=1");
    $stmt->bindParam(1, $eshopId, PDO::PARAM_INT);
    $stmt->bindParam(2, $type, PDO::PARAM_STR);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row)
    {
        return [];
    } else 
    {
        return $row;
    }
}

/*data pošlou se všechna data získaná od Shoptet API v array, type: rozliseni na vice API v jedne tabulce*/
function addEshop(Array $data, string $type)
{
    $database = new PDO('mysql:dbname='.MySQL_DB.';host='.MySQL_SERVER.';port=3306;charset=utf8', MySQL_USER, MySQL_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $database->prepare("INSERT INTO `shoptet_api` (`addon`, `eshop_url`, `eshopId`, `created_at`, `last_update`, `access_token`, `contact_email`) VALUES(?, ?, ?, now(), now(), ?, ?)");
    
    $stmt->bindParam(1, $type, PDO::PARAM_STR);
    $stmt->bindParam(2, $data["eshopUrl"], PDO::PARAM_STR);
    $stmt->bindParam(3, $data["eshopId"], PDO::PARAM_INT);
    $stmt->bindParam(4, $data["access_token"], PDO::PARAM_STR);
    $stmt->bindParam(5, $data["contactEmail"], PDO::PARAM_STR);

    $stmt->execute();

    $lastInsert = $database->lastInsertId();

    return $lastInsert !== null ? true : false;
}

/*Pause true/false, eshopId: int, type: rozliseni na vice API v jedne tabulce*/
function pauseEshop(int $pause, int $eshopId, string $type)
{
    $database = new PDO('mysql:dbname='.MySQL_DB.';host='.MySQL_SERVER.';port=3306;charset=utf8', MySQL_USER, MySQL_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $database->prepare("UPDATE `shoptet_api` SET `active`=? WHERE `eshopId`=? AND `addon`=?");
    
    //Otočení logiky boolu
    $pause = $pause == 1 ? 0 : 1;

    $stmt->bindParam(1, $pause, PDO::PARAM_INT);
    $stmt->bindParam(2, $eshopId, PDO::PARAM_INT);
    $stmt->bindParam(3, $type, PDO::PARAM_STR);
    
    $stmt->execute();
}

/*eshopID: id eshopu int, type: rozliseni na vice API v jedne tabulce*/
function removeEshop(int $eshopId, string $type)
{
    $database = new PDO('mysql:dbname='.MySQL_DB.';host='.MySQL_SERVER.';port=3306;charset=utf8', MySQL_USER, MySQL_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $database->prepare("DELETE FROM `shoptet_api` WHERE `eshopId`=? AND `addon`=?");

    $stmt->bindParam(1, $eshopId, PDO::PARAM_INT);
    $stmt->bindParam(2, $type, PDO::PARAM_STR);
    
    $stmt->execute();
}


/*Pause true/false, eshopId: int, type: rozliseni na vice API v jedne tabulce*/
function updateAccessToken(int $eshopId, string $type, string $token, int $length)
{
    $database = new PDO('mysql:dbname='.MySQL_DB.';host='.MySQL_SERVER.';port=3306;charset=utf8', MySQL_USER, MySQL_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $database->prepare("UPDATE `shoptet_api` SET `active_access_token`=?, `last_update`=? WHERE `eshopId`=? AND `addon`=?");
    
    $stmt->bindParam(1, $token, PDO::PARAM_STR);
    $stmt->bindParam(2, date("Y-m-d H:i:s", strtotime("+".$length." seconds")), PDO::PARAM_STR);
    $stmt->bindParam(3, $eshopId, PDO::PARAM_INT);
    $stmt->bindParam(4, $type, PDO::PARAM_STR);
    
    $stmt->execute();
}
