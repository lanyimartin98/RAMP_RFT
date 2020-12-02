<?php
function connect(){
require_once('auth.php');
$dsn = "mysql:host=localhost;dbname=used_cars";
$user = "root";
$passwd = "";

try {
  $conn = new PDO($dsn,$user,$passwd);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $conn;
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  
}
}
function getAllCars(){
    $conn=connect();
    $response=array();
    $car=array();
    $sql="SELECT * FROM cars";
    foreach($conn->query($sql) as $row) {
        $car['id']=$row['id'];
        $car['name']=$row['name'];
        $car['price']=$row['price'];
        $car['year_of_production']=$row['year_of_production'];
        $car['state']=$row['state'];
        $car['body_style']=$row['body_style'];
        $car['milage']=$row['milage'];
        $car['doors']=$row['doors'];
        $car['type_of_gas']=$row['type_of_gas'];
        $car['engine_capacity']=$row['engine_capacity'];
        $car['horsepower']=$row['horsepower'];
        $car['wheel_driven']=$row['wheel_driven'];
        $car['transmission']=$row['transmission'];
        $car['advertiser_id']=$row['advertiser_id'];
        $car['picture']=$row['picture'];
        $response[]=$car;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function getCarByID($id){
    $conn=connect();
    $car=array();
    $sql="SELECT * FROM cars WHERE id=$id";
    foreach($conn->query($sql) as $row) {
        $car['id']=$row['id'];
        $car['name']=$row['name'];
        $car['price']=$row['price'];
        $car['year_of_production']=$row['year_of_production'];
        $car['state']=$row['state'];
        $car['body_style']=$row['body_style'];
        $car['milage']=$row['milage'];
        $car['doors']=$row['doors'];
        $car['type_of_gas']=$row['type_of_gas'];
        $car['engine_capacity']=$row['engine_capacity'];
        $car['horsepower']=$row['horsepower'];
        $car['wheel_driven']=$row['wheel_driven'];
        $car['transmission']=$row['transmission'];
        $car['advertiser_id']=$row['advertiser_id'];
        $car['picture']=$row['picture'];
        
    }
    header('Content-Type: application/json');
    echo json_encode($car);
}
function addCar(){
    $input = json_decode(file_get_contents('php://input'), true);
    $conn=connect();
    $sql="INSERT INTO cars (id, name, price, year_of_production, state, body_style, milage, doors, type_of_gas, engine_capacity, horsepower, wheel_driven, transmission, advertiser_id, picture) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    try{
        $conn->prepare($sql)->
        execute(array(NULL, $input['name'], $input['price'], $input['year_of_production'], 
        $input['state'], $input['body_style'], $input['milage'], $input['doors'], $input['type_of_gas'], 
        $input['engine_capacity'], $input['horsepower'], $input['wheel_driven'], $input['transmission'], 
        $input['advertiser_id'], $input['picture']));
        header('Content-Type: application/json');
    }catch(Exception $e){
        echo json_encode($e);
        header('Content-Type: application/json');
    }
}
function deleteCarByID($id){
    $conn=connect();
    $sql="DELETE FROM cars WHERE id=$id";
    try{
        $result=$conn->query($sql);
        echo json_encode($result);
        header('Content-Type: application/json');
    }catch(Exception $e){
        echo json_encode($e);
        header('Content-Type: application/json');
    }
}
function updateCarByID($id){
    
}
function getUser(){
    $input = json_decode(file_get_contents('php://input'), true);
    $conn=connect();
    $username=$input['username'];
    $pw=sha1($input['pw']);
    $sql="SELECT * FROM users WHERE username=? AND pw=?";
    $stmt=$conn->prepare($sql);
    $stmt->execute(array($username,$pw));
    
    if($stmt->rowCount()==1) {
        $token=generateToken();
        $conn=connect();
        $sql="UPDATE users SET token=? WHERE username=?";
        $stmt=$conn->prepare($sql);
        $stmt->execute(array($token,$username));
        echo(json_encode($token));
        header('Content-Type: application/json');
    } else {
        header('Content-Type: application/json');
        header('Status: 401');
  }
}
function getToken($token){
    $conn=connect();
    $sql="SELECT * FROM users WHERE token=?";
    $stmt=$conn->prepare($sql);
    $stmt->execute(array($token));
    
    if($stmt->rowCount()==1) {
        return true;
    } else {
        return false;
  }

}
function crashToken($token){
    $conn=connect();
    $sql="UPDATE users SET token=null WHERE token=?";
    $stmt=$conn->prepare($sql);
    $stmt->execute(array($token));
}

?>