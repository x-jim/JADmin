<?php
$get = trim($_GET['lst']);
$sql = "SELECT * FROM ".$get."";
$consulta = mysql_query($sql) or exit (mysql_error());
$consultx =  mysql_query($sql) or exit (mysql_error());
?>
<script language="JavaScript" type="text/javascript" src="js/jTPS.js"></script>
<link rel="stylesheet" type="text/css" href="css/jTPS.css">
<!-- Estilos de la tabla -->
<style>
#jadmin_lista thead th {
	white-space: nowrap;
	overflow-x:hidden;
	padding: 3px;
}
#jadmin_lista tbody td {
	padding: 3px;
	min-height:40px !important;	
}
#jadmin_lista {
	width:788px;
}
#ventana {
	text-align:center;
	width:250px;
	margin-left:50px;
}
#ventana a{
	text-decoration:none;
	display:block;
}
#ventana img{
	padding:5px;
}
.boton img{
	cursor:pointer;
}
</style>
<div id="ventana"><p><a href="#" class="btn edit" id="boton_editar">Editar</a></p><p><a href="#" class="btn delete" id="boton_eliminar">Eliminar</a><p></div>
<div id="ventana_eliminar"></div>
<table id="jadmin_lista" cellspacing="0">
<thead>
    <tr>
    <?php 
    $campos=0;
    while ($campo = mysql_fetch_field($consulta)) {
        $campos++; 
    ?>
        <th sort="index"><?php echo ucfirst(str_replace("_"," ",$campo->name));?></th>
    <?php 
    } 
    ?>
    </tr>
</thead>
<tbody>
	<?php 
    $n=0;
	$s=0;
    # Registros
    while ($dato=mysql_fetch_array($consulta)){ 
	$s++;
		$campox = mysql_fetch_field($consultx);
		
		if (@$campox->primary_key==1){
			$index=$campox->name;
		}
		if (@is_null($index)){
			$index=$campox->name;
			$no_index="&aviso=1";
		} else {
			$no_index=false;
		}
		?>
       <!-- window.open('jadmin_formulario.php?tabla=<?php echo $_GET['lst']; ?>&indice=<?php echo $index; ?>&id=<?php echo $dato[$index]; ?><?php echo $no_index;?>','Editar','width=700,height=600,scrollbars=yes');-->
		<tr onclick="abrir_ventana('tabla=<?php echo $_GET['lst']; ?>&indice=<?php echo $index; ?>&id=<?php echo $dato[$index]; ?><?php echo $no_index;?>','<?php echo $_GET['lst']; ?>','<?php echo $dato[$index];?>');">
		<?php 
		# Campos
		for($n=0; $n<$campos; $n++){ 
		?>
			<td align="right"><?php echo  utf8_encode(substr(strip_tags($dato[mysql_field_name($consulta,$n)]),0,50));?></td>
		<?php } ?>
        </tr>
		<?php 
		$n++;
    } 
    ?>
</tbody>
<tfoot class="nav">
    <tr>
        <td colspan=<?php echo $campos; ?>>
            <div class="pagination"></div>
            <div class="paginationTitle">Página</div>
            <div class="selectPerPage"></div>
            <div class="status"></div>
        </td>
    </tr>
</tfoot>
</table>
<?php 
if ($s<11){
	$inicial=$s;
} else {
	$inicial=11;
}
?>
<script>
$(document).ready(function () {
	$('#jadmin_lista').jTPS( {perPages:[<?php echo $inicial; ?>,<?php echo $inicial+9; ?>,<?php echo $inicial+29; ?>,<?php echo $inicial+69; ?>,'TODO (<?php echo $s; ?>)'],scrollStep:1,scrollDelay:30,
			clickCallback:function () {     
					// target table selector
					var table = '#jadmin_lista';
					// store pagination + sort in cookie 
					document.cookie = 'jTPS=sortasc:' + $(table + ' .sortableHeader').index($(table + ' .sortAsc')) + ',' +
							'sortdesc:' + $(table + ' .sortableHeader').index($(table + ' .sortDesc')) + ',' +
							'page:' + $(table + ' .pageSelector').index($(table + ' .hilightPageSelector')) + ';';
			}
	});
	
	// reinstate sort and pagination if cookie exists
	var cookies = document.cookie.split(';');
	for (var ci = 0, cie = cookies.length; ci < cie; ci++) {
			var cookie = cookies[ci].split('=');
			if (cookie[0] == 'jTPS') {
					var commands = cookie[1].split(',');
					for (var cm = 0, cme = commands.length; cm < cme; cm++) {
							var command = commands[cm].split(':');
							if (command[0] == 'sortasc' && parseInt(command[1]) >= 0) {
									$('#jadmin_lista .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
							} else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
									$('#jadmin_lista .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
							} else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
									$('#jadmin_lista .pageSelector:eq(' + parseInt(command[1]) + ')').click();
							}
					}
			}
	}
	
	// bind mouseover for each tbody row and change cell (td) hover style
	$('#jadmin_lista tbody tr:not(.stubCell)').bind('mouseover mouseout',
			function (e) {
					// hilight the row
					e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
			}
	);
	
				
	// Ventana de controles
	$('#ventana').dialog({
		autoOpen: false,
		width: 338,
		height: 120,
		title: ' Acción'
	});
	

}); //doc ready

function eliminar(tabla,id,url){
	// Eliminar
	$('#ventana_eliminar').dialog({
		autoOpen: false,
		width: 600,
		title: '¿Eliminar registro nº '+id+' de la tabla '+tabla+'?',
		buttons: {
			"Eliminar": function() { 
				document.location.href=''+url+'';
			}, 
			"Cancelar": function() { 
				$(this).dialog("close"); 
			} 
		}
	});
	$('#ventana_eliminar').html("<h3>Estas apunto de eliminar el registro nº"+id+" de la tabla "+tabla+",<br /> ¿Deseas continuar?</h3>");
	$('#ventana').dialog('close');
	$('#ventana_eliminar').dialog('open');
}

function abrir_ventana(url,tabla,id){
	//$('#ventana').html('<a href="#" class="btn edit" onclick="window.open(\'jadmin_formulario.php?'+url+'\',\'Editar\',\'width=700,height=600,scrollbars=yes\'),$(\'#ventana\').dialog(\'close\');">Editar</a><a href="#" class="btn edit" onclick="eliminar(\''+tabla+'\',\''+id+'\',\'eliminar.php?'+url+'\');">Eliminar</a>');
	$('#boton_editar').attr('onclick','window.open(\'jadmin_formulario.php?'+url+'\',\'Editar\',\'width=700,height=600,scrollbars=yes\'),$(\'#ventana\').dialog(\'close\');');
	$('#boton_eliminar').attr('onclick','eliminar(\''+tabla+'\',\''+id+'\',\'eliminar.php?'+url+'\');');
	$('#ventana').dialog('open');
	return false;
}
</script>
