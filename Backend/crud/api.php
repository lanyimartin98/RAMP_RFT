<?php 
require_once('../database.php');
require_once('../auth/auth.php');
$request_method=$_SERVER["REQUEST_METHOD"];
$headers = apache_request_headers();
switch($request_method) {
    case 'GET':
        if (empty($_GET["id"])) {
            getAllCars();
          }
          else {
              $id=$_GET["id"];
              getCarByID($id);
          }
    break;
    case 'POST':
        if(checkToken()){
        addCar();
        }
        break;
    case 'PUT':
        if(checkToken()){
        echo "Great Success";
        }
        break;
    case 'DELETE':
        if(checkToken()){
        $id=$_GET["id"];
        deleteCarByID($id);
        }
        break;
}
?>