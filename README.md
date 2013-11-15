¿Qué es JADmin?
===============

JADmin es un sistema que genera automáticamente un administrador para tu sitio web, tan solo hay que indicarle la configuración de la base de datos.

Características:
================

* Administración total, insertar, editar y eliminar registros.
* Generación automática de la interfaz.
* Generación automática de formularios.
* Generación automática de consultas SQL (INSERT, UPDATE y DELETE).
* Sistema heurístico de detección de campos, con su respectivo formato.
* Fácil instalación.
* Sistema de validación automático, dependiendo del tipo de campo, longitud, email, password, nulo, booleanos etc...
* Interfaz de administración super sencilla.
* *Sistema de joins, para obtener información de otras tablas y crear sus respectivos selects. (OPCIONAL)

JADmin es compatible con MySQL y esta desarrollado en PHP.

IMPORTANTE:
===========

* Es necesario que todas las tablas tengan un id autonumérico (Primary KEY), para poder gestionarlas correctamente.
* Si en la base de datos tienes en la estructura de un campo como NULO = SI, éste campo no tendrá validación alguna.
* Si el campo es de tipo INT (11), el campo se validará como numérico de longitud máxima de 11 dígitos antes de enviar el formulario.
* Contraseñas en MD5, automáticamente JADmin cuando detecta un campo tipo password, almacena las contraseñas en md5.
* Hay una opción de debug, se activa desde el config.

Si necesitas ayuda dirígete al [foro de soporte oficial] (http://www.x-jim.net/foro/?pagina=mensaje&id=135)
o bien utiliza el enlace de ayuda de la propia aplicación