<?php

include "./Functions/database.php";

// Your client ID in the OAuth server
// This is an example only. For a specific value,
// refer to Partner e-shop administration -> Connections -> API partner -> Access to API
$clientId = '';

// Your secret string for communicating with the OAuth server
// If, in Partner e-shop administration -> Connections -> API partner -> Access to API,
// you do not see the value, clientSecret has not been activated (older API partners),
// so do not send it in communication // with OAuth server
$clientSecret = '';

// URL for authorization vs. OAuth server
// This is an example only. For a specific value,
// refer to Partner e-shop administration -> Connections -> API partner -> Access to API
$oAuthServerTokenUrl = 'https://test1.uplab.cz/action/ApiOAuthServer/token';

// Received value of code
$code = $_GET['code'];

// OAuth server authorization type, always enter 'authorization_code'
$grantType = 'authorization_code';

// OAuth server rights group, always enter 'api'
$scope = 'api';

// URL entered on the addon settings page that you expect a request with the parameter 'code' for example:
$redirectUri = 'https://vyvoj.prezza.cz/ShoptetAPI/konfigurator-install.php';

// Sending the request to get secret_token
$data = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret, // Enter only if set for you
    'code' => $code,
    'grant_type' => $grantType,
    'redirect_uri' => $redirectUri,
    'scope' => $scope,
];
$curl = curl_init($oAuthServerTokenUrl);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
$response = curl_exec($curl);
curl_close($curl);

// Vytahnuti dat z URL
$response = json_decode($response, TRUE);

//Přidání do databáze
try{
    addEshop($response, $_GET["addon"]);
}
catch (PDOException $e){
    $response["File"] = $_SERVER['SCRIPT_NAME'];
    $response["Exception"] = $e->getMessage();
    $log = fopen("./logs/error-".date("Y-m-dTH-i-s").".txt", "w");
    fwrite($log, json_encode($response));
    fclose($log);
}
catch (Exception $e){
    $response["File"] = $_SERVER['SCRIPT_NAME'];
    $response["Exception"] = $e->getMessage();
    $log = fopen("./logs/error-".date("Y-m-dTH-i-s").".txt", "w");
    fwrite($log, json_encode($response));
    fclose($log);
}
catch (Error $e){
    $response["File"] = $_SERVER['SCRIPT_NAME'];
    $response["Error"] = $e->getMessage();
    $log = fopen("./logs/error-".date("Y-m-dTH-i-s").".txt", "w");
    fwrite($log, json_encode($response));
    fclose($log);
}