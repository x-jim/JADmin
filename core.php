<?php 
################################
##        CORE de JADmin      ##
##     Joel Ibañez Miquel     ##
## diablonegro700@hotmail.com ##
##     http://www.x-jim.net   ##
################################

include('config.php');

# Función de conexión	
function conex ($h,$u,$p,$db){
	mysql_connect($h,$u,$p) or exit ("Conexión: core.php |  ".mysql_error());
	mysql_select_db($db) or exit ("Conexión Select DB: core.php |  ".mysql_error());
}
conex($host_cfg,$usuario_cfg,$password_cfg,$base_cfg);

# Función de seguridad
function seg ($seg) {
	 $seg = trim($seg);
	  /*
	 $seg = stripslashes($seg);
	 $seg = str_replace('\\'," ",$seg);
	 $seg = str_replace('&#39;','',$seg);
	 $seg = str_replace("'",'',$seg);
	 $seg = str_replace("%",'',$seg);
	 $seg = strip_tags($seg);
	 $seg = str_replace("<",'',$seg);
	 */
	 $seg = stripslashes($seg);
	 $seg = mysql_real_escape_string($seg);
	 
	 return $seg;
}

# Función INSERT y UPDATE
function dbe()
{
    //Bucle
    foreach ($_POST as $clave=>$valor){
        if($clave!="jadmin_tabla_db"){
            //Indices y Valores
			if (($clave=="password" or $clave=="pwd" or $clave=="contrasenya") and $valor!="jadmin"){
				@$claves .= ",".seg($clave);
				@$valors .= ",'".md5(seg($valor))."'";
			} else {
				@$claves .= ",".seg($clave);
				@$valors .= ",'".seg($valor)."'";
			}
			
			// Esto solo hara efecto en los updates
			if (($clave=="password" or $clave=="pwd" or $clave=="contrasenya") and $valor=="jadmin") {
				// lo dejamos en blanco si no actualizamos la contraseña
			} elseif (($clave=="password" or $clave=="pwd" or $clave=="contrasenya") and $valor!="jadmin") { 
				//generamos un md5 de la contraseña
				@$upd .= ",".seg($clave)."='".md5(seg($valor))."'";
			} else {
            	@$upd .= ",".seg($clave)."='".seg($valor)."'";
			}
        } else {
            //Nombre de la tabla
            $tabla=$valor;   
        }
    }
    //SQL Generado + Condición por si falla.
    $sql = "INSERT INTO ".$tabla." (".substr($claves,1).") VALUES (".utf8_decode(substr($valors,1)).") ON DUPLICATE KEY UPDATE ".utf8_decode(substr($upd,1))."";
    if (!mysql_query($sql) or exit (mysql_error())){
        echo "SQL: ".$sql."<br /><br />";
        echo mysql_error();
    }
}

# Explode de la lista de tablas, definida en el config.php
$exp = explode(",",$lista_de_tablas);

# Condicional que comprueba que existan tablas
if (!empty($lista_de_tablas)){
	# Bucle que generara la variable con la lista de campos
	for($x=0; $x<count($exp); $x++){
		if($x!=0){
			$coma = ",";
		}
		$tablas_a_mostrar .= $coma."'".$exp[$x]."'";
	}
	
	# Variable de prefijo para consulta con listados de no mostrar.
	if (!empty($prefijo)){
		$prefijado = "AND Tables_in_".$base_cfg." NOT LIKE '".$prefijo."%'";
	}
	
	# Consulta de tablas a mostrar
	$sql = "SHOW TABLES FROM ".$base_cfg." WHERE Tables_in_".$base_cfg." IN (".$tablas_a_mostrar.") ".$prefijado."";
} else {
	
	# Variable de prefijo
	if (!empty($prefijo)){
		$prefijado = "WHERE Tables_in_".$base_cfg." NOT LIKE '".$prefijo."%'";
	}
	
	$sql = "SHOW TABLES FROM $base_cfg ".$prefijado."";
}

define ('APP',"JADmin");
define ('VER',"V1.3 beta");
define ('AUTOR',"x-jim");
define ('URL',"http://www.x-jim.net");
define ('APLICACIONES',"Este sistema utiliza jTPS, FancyInput y jQuery.Validate.");
?>