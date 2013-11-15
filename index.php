<?php 
session_start();

include('core.php');

if ($_POST){
	if ($jadmin_usuario==$_POST['usuario'] and $jadmin_password==$_POST['password']){
		$_SESSION['jadmin_usuario']=$_POST['usuario'];
		$_SESSION['jadmin_password']=$_POST['password'];
	}
}

if (isset($_SESSION['jadmin_usuario']) and ($_SESSION['jadmin_usuario']==$jadmin_usuario and $_SESSION['jadmin_password']==$jadmin_password)){
	$user = $_SESSION['jadmin_usuario'];
	$pass = $_SESSION['jadmin_password'];
	if ($user == $jadmin_usuario and $pass == $jadmin_password){
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo APP."  ".VER; ?></title>
	<link rel="stylesheet" type="text/css" href="css/jadmin.css">
    <link rel="stylesheet" type="text/css" href="includes/jquery-ui/css/ui-lightness/jquery-ui-1.8.16.custom.css">
	<script src="js/jquery1.7.js" type="text/javascript"></script>
    <script type="text/javascript" src="includes/jquery-ui/js/jquery-ui-1.8.16.custom.min.js"></script>
    
    <!-- Kit Botones -->
    <script src="js/init.js" type="text/javascript"></script>
    <link href="css/botones.css" rel="stylesheet" type="text/css" />
    <!-- Fin Botones -->
    
	</head>
	<body>
	<script>
	$(document).ready(function(){
		$("#menu_jadmin_<?php echo $_GET['lst']; ?>").addClass("activo",true);
		$("#nuevo").click(function() {
			window.open('jadmin_formulario.php?tabla=<?php echo $_GET['lst']; ?>','Nuevo','width=700,height=600,scrollbars=yes');
		});
	});
	</script>
	<div id="capa_jadmin">
        
        <?php if (!empty($user)){ ?>
        <div id="logueado"><a href="index.php">Inicio</a> | <a href="http://www.x-jim.net/app/jadmin/ayuda.php">Ayuda</a> | <a href="cerrar_sesion.php">Cerrar sesión</a></div>
        <?php } ?>
        
		<div id="logo_jadmin">
		<?php
		if (!empty($titulo)){
			echo $titulo;
		} else {
			echo APP."  ".VER; 
		}
		?>
        </div>
		
		<div class="tablas">Admin</div>
		<div class="contenido">
		CONTENIDO 
		<?php 
		if(!empty($_GET['lst'])){ 
			echo "DE ".strtoupper($_GET['lst']);
		}
		?>
		</div>
		
		<div class="clear"></div>
		
        <div id="controles"><?php if(!empty($_GET['lst'])){ ?><a style="cursor:pointer;"><a href="#" class="btn add" id="nuevo">Nuevo</a></a><?php } ?></div>
        
		<div id="menu_jadmin">
			<div id="menu">
				<ul>
					<?php
					//$sql = "SHOW TABLES FROM $base_cfg";
					$resultado = mysql_query($sql);
					while ($dato = mysql_fetch_row($resultado)) {
						echo "<li><a href=\"?lst=".$dato[0]."\" id=\"menu_jadmin_".$dato[0]."\" >".ucfirst(str_replace("_"," ",$dato[0]))."</li></a>";
					}
					mysql_free_result($resultado);
					?>
				</ul>
			</div>
		</div>
		
		<div id="contenido_jadmin">
		<?php
		if (isset($_GET['lst'])){
			$lista = seg($_GET['lst']);
		}
		if(isset($lista)){
			include('lista.php');
		} else {
			include('bienvenido.php');
		}
		?>
		</div>
		
		<div class="clear"></div>
		
		<div id="pie_jadmin">
		Desarrollado por <?php echo "<a href=\"".URL."\" target=\"_blank\">".AUTOR."</a> // ".APP."  ".VER."<br />".APLICACIONES; ?>
		</div>
	</div>
	</body>
	</html>
	<?php 
	} 
} else {
	include('login.php');
}
?>