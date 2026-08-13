<?php
class Conexion{
	public function get_conexion(){
		include ("config.php");
		$conexion = new PDO("mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4",$user,$pass);
		return $conexion;
	}
}
?>
