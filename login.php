<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery1.7.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/jadmin.core.css">
<title>Login - jAdmin</title>
<style>
#jadmin_login {
	margin:0 auto;
	width: 400px;
	text-align:center;
}
</style>
</head>

<body>
<div id="jadmin_login">
<form id="jadmin_frm" action="index.php" method="post">
<fieldset>
	<legend style="font-size:14px; font-weight:bold;">JADmin - Login</legend>
	Usuario<br />
    <input type="text" name="usuario" class="required fancyinput"/>
    <br />
    Contraseña<br />
    <input type="password" name="password" class="required fancyinput"/>
    <br /><br />
    <input type="button" name="Enviar" value="Enviar" id="enviar" class="fancyinput"/>
</fieldset>
</form>
Desarrollado por <?php echo "<a href=\"".URL."\" target=\"_blank\">".AUTOR."</a> // ".APP."  ".VER; ?>
</div>
<script>
//Función enviar y validar
$('#enviar').click(function(){
	if ($("#jadmin_frm").validate().form()){
		$("#jadmin_frm").submit();
	} 
});
</script>
</body>
</html>