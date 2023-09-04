<?php
if(!defined(API_TOKEN)) include "../settings.php";

//includujeme getAccessToken a tokenCheck funkce
if(!function_exists("getAccessToken")){
    if(file_exists("getAccessToken.php")) include "getAccessToken.php";
    else if(file_exists("../Functions/getAccessToken.php")) include "../Functions/getAccessToken.php";
    else throw new Exception("Nenalezen soubor s getAccessToken (getData.php)");
}

/*URL je z API - co chci dostat ven, eshopId int id eshopu, type - typ doplnku (napr. konfigurator), muze jich byt v jedne tabulcke vic*/
function getData(string $url, int $eshopId, string $type){
    // the value saved by the installation process, unique for each e-shop
    $OauthAccessToken = tokenCheck($eshopId, $type);

    // OAuth access token is to be added to the request hader
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/vnd.shoptet.v1.0', 
        'Shoptet-Access-Token: ' . $OauthAccessToken
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response, TRUE);

    $response["pouzity_access_token"] = $OauthAccessToken;
    $response["zavolana_url"] = $url;
    
    return $response;
}