�Qu� es JADmin?
===============

JADmin es un sistema que genera autom�ticamente un administrador para tu sitio web, tan solo hay que indicarle la configuraci�n de la base de datos.

Caracter�sticas:
================

* Administraci�n total, insertar, editar y eliminar registros.
* Generaci�n autom�tica de la interfaz.
* Generaci�n autom�tica de formularios.
* Generaci�n autom�tica de consultas SQL (INSERT, UPDATE y DELETE).
* Sistema heur�stico de detecci�n de campos, con su respectivo formato.
* F�cil instalaci�n.
* Sistema de validaci�n autom�tico, dependiendo del tipo de campo, longitud, email, password, nulo, booleanos etc...
* Interfaz de administraci�n super sencilla.
* *Sistema de joins, para obtener informaci�n de otras tablas y crear sus respectivos selects. (OPCIONAL)

JADmin es compatible con MySQL y esta desarrollado en PHP.

IMPORTANTE:
===========

* Es necesario que todas las tablas tengan un id autonum�rico (Primary KEY), para poder gestionarlas correctamente.
* Si en la base de datos tienes en la estructura de un campo como NULO = SI, �ste campo no tendr� validaci�n alguna.
* Si el campo es de tipo INT (11), el campo se validar� como num�rico de longitud m�xima de 11 d�gitos antes de enviar el formulario.
* Contrase�as en MD5, autom�ticamente JADmin cuando detecta un campo tipo password, almacena las contrase�as en md5.
* Hay una opci�n de debug, se activa desde el config.

Si necesitas ayuda dir�gete al [foro de soporte oficial] (http://www.x-jim.net/foro/?pagina=mensaje&id=135)
o bien utiliza el enlace de ayuda de la propia aplicaci�n