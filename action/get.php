<?php
include "../settings.php";
include "../Functions/getAccessToken.php";
include "../Functions/getData.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
    if($_SERVER['REQUEST_METHOD'] != 'POST') throw new Exception("Pouzijte prosim method POST");


    if(!isset($_POST["url"]) || !isset($_POST["eshopId"]) || !isset($_POST["type"])) throw new Error("Nezadány povinné parametry: url, eshopId, type");
    echo json_encode(getData($_POST["url"], $_POST["eshopId"], $_POST["type"]));

} catch (PDOException $e){
    echo json_encode(["errors"=>"PDOException: ".$e->getMessage()]);
} catch (Exception $e){
    echo json_encode(["errors"=>"Exception: ".$e->getMessage()]);
} catch (Error $e){
    echo json_encode(["errors"=>"Error: ".$e->getMessage()]);
}