<?php 
# Eliminar
session_start();

if (!empty($_SESSION['jadmin_usuario'])){
	include('core.php');
	
	$tabla = seg($_GET['tabla']);
	$indice = seg($_GET['indice']);
	$id = seg($_GET['id']);
	
	$sql = "DELETE FROM ".$tabla." WHERE ".$indice."= '".$id."'";
	$consulta = mysql_query($sql) or exit (mysql_error());
	
	header("Location: index.php?lst=".$tabla."");
}
?>