<?php
include "./Functions/database.php";

$body = file_get_contents('php://input');
$webhook = json_decode($body, TRUE);

//Úprava databáze
try{
    pauseEshop(0, $webhook["eshopId"], $_GET["addon"]);
} 
catch (PDOException $e){
    $webhook["File"] = $_SERVER['SCRIPT_NAME'];
    $webhook["Exception"] = $e->getMessage();
    $log = fopen("./logs/error-".date("Y-m-dTH:i:s").".txt", "w");
    fwrite($log, json_encode($webhook));
    fclose($log);
}
catch (Exception $e){
    $webhook["File"] = $_SERVER['SCRIPT_NAME'];
    $webhook["Exception"] = $e->getMessage();
    $log = fopen("./logs/error-".date("Y-m-dTH:i:s").".txt", "w");
    fwrite($log, json_encode($webhook));
    fclose($log);
}
catch (Error $e){
    $webhook["File"] = $_SERVER['SCRIPT_NAME'];
    $webhook["Error"] = $e->getMessage();
    $log = fopen("./logs/error-".date("Y-m-dTH:i:s").".txt", "w");
    fwrite($log, json_encode($webhook));
    fclose($log);
}