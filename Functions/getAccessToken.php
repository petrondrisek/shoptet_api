<?php

if(!defined(API_TOKEN)) include "../settings.php";

//Includujeme funkci pracující s databází - findEshop
if(!function_exists("findEshop")){
    if(file_exists("database.php")) include "database.php";
    else if(file_exists("../Functions/database.php")) include "../Functions/database.php";
    else{
        throw new Exception("Nenalezen soubor s databází (getAccessToken.php)");
    }
}

/* eshopId: int eshop id, type: typ doplnku, muze jich byt vice v tabulce */
function getAccessToken(int $eshopId, string $type){
    $apiAccessTokenUrl = 'https://test1.uplab.cz/action/ApiOAuthServer/getAccessToken';

    $OauthAccessToken = findEshop($eshopId, $type)["access_token"];
    
    // OAuth access token is to be added to the request hader
    $curl = curl_init($apiAccessTokenUrl);
    curl_setopt($curl, CURLOPT_FRESH_CONNECT, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $OauthAccessToken, "Cache-Control: no-cache"]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    curl_close($curl);
    
    $response = json_decode($response, TRUE);

    if(!isset($response['access_token'])){
        $response["File"] = $_SERVER['SCRIPT_NAME'];
        $log = fopen("../logs/error-".date("Y-m-dTH-i-s").".txt", "w");
        fwrite($log, json_encode($response));
        fclose($log);

        throw new Exception("Nepovedlo se spojit s Shoptet API, nebyl získán token.");
    }

    /*Ověření*/
    //echo "<strong>Vygenerován nový access token: </strong>";
    //print_r($response);
    
    return isset($response['access_token']) ? ["token"=>$response['access_token'], "expires_in"=>$response['expires_in']] : null;
}

function tokenCheck(int $eshopId, string $type){
    //První ověříme, jestli nepoužíváme testovací access token - lze vygenerovat v administraci.
    if(!empty(API_TOKEN)) {
        return API_TOKEN;
     } else {
        $data = findEshop($eshopId, $type);

        if(!isset($data["last_update"])){
            throw new Exception("Nenalezen řádek eshopu.");
        }
    
        if($data["active"] == 0){
            throw new Exception("Doplněk je pozastavený.");
        }

        //Pokud je token vypršelý vygeneruje se nový
        if(strtotime("now") > strtotime($data["last_update"])){
            $tokenData = getAccessToken($eshopId, $type);

            updateAccessToken($eshopId, $type, $tokenData["token"], $tokenData["expires_in"]);

            return $tokenData["token"];
        } else {
            return $data["active_access_token"]; //Jinak posíláme ten z databáze uložený
        }
     }

     //Pro všechny případy returneme null
     return null;
}