<script src="js/jquery1.7.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/jadmin.core.css">
<?php 
/*************************************************************
	Sistema de Administración Automático
	Se basa en un sistema que crea backends de forma
	automática, basado en un servidor PHP + MySQL, el sistema
	está dotado de validación y reconocimiento de campos.
**************************************************************/

$id = @trim(mysql_real_escape_string($_GET['id']));
if (empty($id)){
	$sql = "SELECT * FROM ".$tabla."";
	$edit = false;
} else {
	# Avisamos si no hay indice y lo sustituimos por otro;
	if(isset($_GET['aviso'])) {
		echo "<script>alert('No he encontrado ningun campo índice!! (Primary Key) He asignado el indice a ".$indice.", pero puede que no funcione.');</script>";
	}
	$sql = "SELECT * FROM ".$tabla." WHERE ".$indice." = '".$id."'";
	$edit = true;
}


$consulta = mysql_query($sql) or exit(mysql_error());
$dato = mysql_fetch_array($consulta);
$registros = mysql_num_rows($consulta);
$consulta = mysql_query($sql) or exit(mysql_error());

if ($registros>0){
?>
<form id="jadmin_frm">
<fieldset>
<legend style="font-size:14px; font-weight:bold;">JADmin - [<?php echo $tabla;?>]</legend>

<?php
$volta=0;
while($meta=mysql_fetch_field($consulta)){
	# Si tenemos el ID debemos llenar los campos.
	if (empty($id)){
		$texto = false;
	} else {
		$texto = $dato[$meta->name];
	}
	# Debug
	if ($debug){
		echo "<br /><b> Debug de: ".$meta->name."</b>";
		echo "<pre>
		blob:         $meta->blob
		max_length:   $meta->max_length
		multiple_key: $meta->multiple_key
		name:         $meta->name
		not_null:     $meta->not_null
		numeric:      $meta->numeric
		primary_key:  $meta->primary_key
		table:        $meta->table
		type:         $meta->type
		unique_key:   $meta->unique_key
		unsigned:     $meta->unsigned
		zerofill:     $meta->zerofill
		</pre>";
	}
	
	# Tipo de campo
	if ($meta->name=="password" or $meta->name=="pwd" or $meta->name=="contrasena" or $meta->name=="contrasenya"){
		$tipo="password";
		$texto = "jadmin";
	} else {
		$tipo="text";
	}
	
	# Si el campo es numerico...
	if ($meta->type=="int"){
		$requerido="number";	
	}
	
	# Si es un email (esto es un poco heurístico.. xD)
	if($meta->name=="email" or $meta->name=="mail"){
		$requerido="email";
	} else {
		$requerido=false;	
	}
	
	# Longitud de campos, en un principio se uso solo para los tinyint 1
	$length = mysql_field_len($consulta, $volta);
	
	# Longitud máxima de campo
	if (!empty($length)){
		$longitud = "maxlength=\"".$length."\"";
	} else {
		$longitud=false;
	}
	
	# Inputs y Labels
	$campo_titulo = str_replace("_"," ",$meta->name);
	$campo_titulo = ucfirst($campo_titulo);
	echo "<p> <label for=\"".$meta->name."\">".$volta." - ".$campo_titulo."</label>";
	
	# Comprobamos los joins y miramos si la tabla coincide, si coincide continuamos con los campos.
	if (@strstr($meta->name,$nfo[$tabla][$volta]['campo'])){
		/*
		echo "<script>alert('\"".$nfo[$tabla][$volta]['campo']."\"');</script>";
		*/
		
		# Consulta
		$sql_1 = "SELECT * FROM ".$nfo[$tabla][$volta]['tabla']."";
		$consulta_1 = mysql_query($sql_1) or exit(mysql_error());
		
		# Tipo de campos de la base de datos
		$dbcampo=mysql_fetch_field($consulta_1);
		echo "<select name=\"".$meta->name."\" class=\"fancyinput\">";
		
		# Si el select es de tipo NULL
		if ($dato[$nfo[$tabla][$volta]['campo']]==0){
			$selected = "selected=\"selected\"";
		}
		
		echo "<option value=\"0\" ".$selected.">NULL</option>";
		while($dat = mysql_fetch_array($consulta_1)){
			
			# Clave primaria (index)
			if ($dbcampo->primary_key==1){
				$clave_primaria=$dbcampo->name;
			}
			
			# Si coincide lo mostraremos como seleccionado por defecto.
			# Solo lo miramos si lo estamos editando, de lo contrario es falso siempre.
			if($edit){
				if ($dato[$nfo[$tabla][$volta]['campo']]==$dat[$clave_primaria]){
					$selected = "selected=\"selected\"";
				} else {
					$selected = false;
				}
			} else {
				$selected = false;
			}
			echo "<option value=\"".$dat[$clave_primaria]."\" ".$selected.">".utf8_encode($dat[$nfo[$tabla][$volta]['mostrar']])."</option>";
		}
		
		echo "</select>";
	} else {
		# Detectamos el indice
		# Indice?
		if ($meta->primary_key==1){
			
			if ($edit){
				$indice = "readonly value=\"".$dato[$meta->name]."\"";
				$req="required";
			} else {
				$indice=false;
				$req=false;
			}
			
			echo "<input type=\"".$tipo."\" name=\"".$meta->name."\" id=\"".$meta->name."\" class=\"".$req." ".$requerido." fancyinput\" ".$longitud." ".$indice." />";
			echo " (&Iacute;ndice)</p>";
		} else {
			if ($meta->type=="blob"){
				# Campos LongText
				echo "<textarea name=\"".$meta->name."\" id=\"".$meta->name."\" class=\"fancyinput\">".utf8_encode($texto)."</textarea>";
			} elseif($meta->type=="int" and $length==1) {
				# Campos Booleanos (1 o 0) aparecen ser como int o tinyint de longitud máxima de 1;
				# Miramos si es edit o no;
				if($edit){
					if ($dato[$meta->name]==0){
						$selected1 = "selected=\"selected\"";
					} else {
						$selected2 = "selected=\"selected\"";
					}
				} else {
					$selected1 = false;
					$selected2 = false;
				}
				
				# Select Booleano
				echo "<select name=\"".$meta->name."\" class=\"fancyinput\">";
					echo "<option value=\"1\" ".$selected2.">SI</option>";
					echo "<option value=\"0\" ".$selected1.">NO</option>";
				echo "</select>";
			} else {
				# Campos normales
				# Comprobamos si puede ser nulo o no.
				if ($meta->not_null==1){
					$requerido = "required";
				} else {
					$requerido = false;
				}
				
				echo "<input type=\"".$tipo."\" name=\"".$meta->name."\" id=\"".$meta->name."\" value=\"".utf8_encode($texto)."\" class=\"".$requerido." ".$requerido." fancyinput\" ".$longitud."/></p>";
			}
		}
	}
	$volta++;
}
?>
<br /><br />
<input type="hidden" name="jadmin_tabla_db" value="<?php echo $tabla; ?>"/>
<input type="button" name="Enviar" value="Enviar" id="enviar" class="fancyinput"/>
</fieldset>
</form>
<div id="resultat"></div>
<script>
//Función enviar y validar
$('#enviar').click(function(){
	if ($("#jadmin_frm").validate().form()){
		$.ajax({
		   type: "POST",
		   url: "<?php echo $action; ?>",
		   data: $("#jadmin_frm").serialize(),
		   success: function(msg){
			 $("#resultat").html(msg);
		   }
		});
	} 
});
</script>
<?php } else { ?>
<div style="width:450px; margin:0 auto; border:1px solid green; background: #E4F1C9; text-align:center; padding:5px;">No hay registros que mostrar</div>
<?php } ?>
