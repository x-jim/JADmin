<?php
# Configuración de MySQL
$host_cfg = "localhost";
$usuario_cfg = "root";
$password_cfg = "";
$base_cfg = "examples";

# Contraseña del administrador
$jadmin_usuario  ="admin";
$jadmin_password ="admin";

# Título del administrador
$titulo="";

# Debug
$debug = false;

/*************************************************
	Tablas que quiero mostrar, separado por comas
	Dejarlo en blanco si se quiere mostrar todo
*************************************************/
//Ejemplo
//$lista_de_tablas = "usuarios,noticias,comentarios";
$lista_de_tablas = "";

/**********************************************
	No mostrar tablas con prefijo..
	Esto sirve para no mostrar tablas 
	de otras aplicaciones con prefijo
	Todo lo que empiece por XXX no se mostrara.
***********************************************/
//Ejemplo
//$prefijo = "smf_";
$prefijo = "piwik_";
?>