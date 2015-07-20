<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
	<title>Campeonato de justas medievales</title>
</head>
<body>
	<h1>Petición de amistad.</h1>
	<p>El caballero Sir {Yii::app()->user->knights_name} acaba de realizar una solicitud de amistad.</p>
	<p>Sabemos que has venido aquí a socializar de una forma virtual y violenta pero cruzar unas palabras con amigos/enemigos no viene nada mal de vez en cuando.</p>	
	<p>Puedes responder a su solicitud de amistad: <a href="{Yii::app()->params['url_domain']}/character/events/sir/{$this->knight->name}">responder a la solicitud de amistad.</a></p>
</body>
</html>