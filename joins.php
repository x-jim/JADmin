<?php 
/********************************************************
Composición de los selects con información en otra tabla:
mensajes => Tabla en que se ejecutara el join.
1        => Número de campo, siempre se empieza desde 0;
tabla    => Tabla de donde sacaremos los datos;
campo    => Con que campo se relacionaría la tabla?
mostrar  => El texto a mostrar en el desplegable. (select)

El ejemplo parece complicado pero en realidad es sencillo.
Cuando edite un registro de la tabla "mensajes" los campos 1, 2, 3 y 4
se activarán como select por cada campo hace un join a una tabla de destino.
el campo es el que se va a relacionar, en este caso "id_foro" y quiero que me muestre
el texto "titulo"

Join a 2 tablas distintas.
********************************************************/

$nfo = array(
	"mensajes"=>array(
		1 => array(
			"tabla" => "foros",
			"campo" => "id_foro",
			"mostrar" => "titulo"
		),
		2 => array(
			"tabla" => "sub_foros", 
			"campo" => "id_subforo", 
			"mostrar" => "titulo"
		),
		3 => array(
			"tabla" => "sub_foros", 
			"campo" => "foro_principal", 
			"mostrar" => "titulo"
		),
		4 => array(
			"tabla" => "usuarios", 
			"campo" => "id_autor", 
			"mostrar" => "nombre"
		)
	),
	"comentarios"=>array(
		1 => array(
			"tabla" => "blog",
			"campo" => "id_entrada",
			"mostrar" => "titulo"
		)
	),
	"online"=>array(
		3 => array(
			"tabla" => "usuarios",
			"campo" => "id_usuario",
			"mostrar" => "nombre"
		)
	),
);
if (isset($debug)){
	if ($debug) {
		echo "<pre>";
		print_r($nfo);
		echo "</pre>";
	}
}
?>