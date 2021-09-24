<?php  
  // Activa Sesion
  session_start();

  // Verifica si esta iniciada para activa el modulo correspondiente
  if (isset($_SESSION['codigo']))
  {
  	 // Obtengo el Tipo
  	 $tipo = $_SESSION['tipo'];

     // Lanzando Aplicación por Tipo
	 header("Location: $tipo.php");	
  }

  // Se realiza la conexion
  require("php/conexion.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Comandas</title>

    <!-- // Incluye bootstrap -->
	<?php include "bootstrap.html"; ?>
	
    <!-- // Incluimos las reglas de estilo de la aplicación--> 
    <link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />

  
</head>
<body>

	<!-- Objeto Navbar de BootStrap -->
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<a class="navbar-brand" href="#">Comandas-Sesion</a>
	</nav>
    
    <!-- // Separador -->
	<br>

	<!-- Contenedor Principal -->
	<div class="container">

		<!-- Encabezado  -->
		<h1>Inicio de Sesión</h1>

		<!-- Formulario de Login -->
		<form action="php/login.php" method="POST">
			
			<div class="form-group">
				<label for   = "codigo">Codigo:</label>
				<input type  = "text" 
				class = "form-control" 
				name  = "codigo">
			</div>

			<div class="form-group">
				<label for   = "clave">Clave:</label>
				<input type  = "password" 
				class = "form-control" 
				value = "admin" 
				name  = "clave">
			</div>
			<button type="submit" class="btn btn-warning">Ingresar</button>
		</form>
	</div>
	
</body>
</html>
