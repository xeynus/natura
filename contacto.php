<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Contacto</title>
<?php include ("head.php"); ?>

</head>
<body id="contacto">

<?php include ("header.php"); ?>


<!--*********************
SECCIONES DESTACADAS
*********************-->
<section>
	<div class="container">
		<div class="row">

<!-- Título -->
			<div class="col-md-12">
				<h1>Contacto</h1>
			</div>
		</div>

<!--*************** Formulario ***************/-->
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 wow fadeInUp">

<!-- Formulario -->
				<form id="contactForm" action="form.php">
					<input class="nombre" type="text" name="nombre" id="nombre" placeholder="Nombre" required="required" />

					<input class="tel" type="tel" placeholder="Teléfono" name="telefono" id="telefono" required="required" />

					<input class="mail" type="email" placeholder="Correo" name="email" id="email" required="required" />

					<textarea name="mensaje" id="mensaje" cols="50" rows="10" placeholder="Mensaje"></textarea>

<!-- Botón -->
					<div class="text-right">
						<button class="boton-enviar" type="submit" id="enviar" name="enviar">
							Envío <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
						</button>
					</div> 

<!-- Alertas -->
					<div class="alertas">
						<div id="retro"></div>
					</div>
				</form>

			</div>
		</div>
	</div>

</section>

<?php include ("footer.php"); ?>

</body>
</html>