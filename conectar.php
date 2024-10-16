<?php


function getConnection(){
$servername ="localhost"; 
$username="root";
$password="";
$dbname="actividadcrud";

$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Conexion fallada ".$conn->connect_error);
}
return $conn;
}
?>