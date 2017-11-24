<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Galería</title>

<link type="text/css" rel="stylesheet" href="foliogallery/foliogallery.css" />

<?php include ("head.php"); ?>

<script type="text/javascript" src="foliogallery/foliogallery.js"></script>

</head>
<body id="galeria">

<?php include ("header.php"); ?>


<!--*********************
GALERIA
*********************-->

<!-- Título -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Galería</h1>
		</div>
	</div>

<!--*************** Galerías ***************/-->
	<section id="estados">
	
		<div class="row">

<!-- CDMX -->
			<div class="col-sm-4">
				<div class="seccion">
					<a href="cdmx.php">
						<figure><img src="albums/cdmx/Destaques-2016-DF02-01.jpg" alt="CDMX"></figure>
						<div class="texto">
							<h2>Ciudad de México</h2>
						</div>
					</a>
				</div>
			</div>

<!-- Guadalajara -->
			<div class="col-sm-4">
				<div class="seccion">
					<a href="guadalajara.php">
						<figure><img src="albums/guadalajara/Destaques2016_Guadalajara-116.jpg" alt="Guadalajara"></figure>
						<div class="texto">
							<h2>Guadalajara</h2>
						</div>
					</a>
				</div>
			</div>

<!-- León -->
			<div class="col-sm-4">
				<div class="seccion">
					<a href="leon.php">
						<figure><img src="albums/leon/Destaques2016_Leon-01.jpg" alt="León"></figure>
						<div class="texto">
							<h2>León</h2>
						</div>
					</a>
				</div>
			</div>
		</div>

		<div class="row">

<!-- Monterrey -->
			<div class="col-sm-4 col-sm-offset-2">
				<div class="seccion">
					<a href="monterrey.php">
						<figure><img src="albums/monterrey/Destaques2016_Veracruz-67.jpg" alt="Monterrey"></figure>
						<div class="texto">
							<h2>Monterrey</h2>
						</div>
					</a>
				</div>
			</div>

<!-- Veracruz -->
			<div class="col-sm-4">
				<div class="seccion">
					<a href="veracruz.php">
						<figure><img src="albums/veracruz/destaques_veracruz-2016-73.jpg" alt="Veracruz"></figure>
						<div class="texto">
							<h2>Veracruz</h2>
						</div>
					</a>
				</div>
			</div>
		</div>

	</section>

</div>


<?php include ("footer.php"); ?>

</body>
</html>