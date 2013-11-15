<?php 
# Inlcuir la conexión a la base de datos (Ajax)
include('core.php');

# Nombre de la tabla, un campo oculto en el formulario
$tabla=$_POST['jadmin_tabla_db'];

# Mostramos algo al usuario
echo "<div style=\"width:450px; margin:0 auto; border:1px solid green; background: #E4F1C9; text-align:center; padding:5px;\">Consulta Realizada</div>";

# Llamada a la función
dbe();
?>