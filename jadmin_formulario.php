<?php 
session_start();

if (!empty($_SESSION['jadmin_usuario'])){
	include('core.php');
	
	$tabla = seg($_GET['tabla']);
	
	if (!empty($tabla)){
		$indice = @$_GET['indice']; // Primary Key de la tabla.
		$action = "jadmin_formulario_post.php"; // Action del formulario, donde hará el POST. (archivo.php)
	}
	
	# Incluimos los joins simulados
	include('joins.php');
	
	# Incluimos el generador de administración.
	include ('jadmin.php');
}
?>