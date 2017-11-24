<?php
$nombre = trim($_POST['nombre']);
$telefono = trim($_POST['telefono']);
$email = trim($_POST['email']);
$mensaje = trim($_POST['mensaje']);

$to = "relacionamientomx@natura.net";
$subject = "Nuevo contacto";
$txt = "Nombre: ".$nombre ."\n" ."Teléfono: ".$telefono ."\n"."Email: ".$email ."\n"."Mensaje: ".$mensaje;
$headers = "From: Destaques Natura" . "\r\n" .
"CC: Destaques Natura";

$ok = ereg("^([a-zA-Z0-9_\.-]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$", $email);

if ($ok) {
	// mail($emailmanager,'Nuevo suscriptor','','From: '.$email);
	echo $ok;

	mail($to,$subject,$txt,$headers);	

	} 

else {
	echo 0;
}