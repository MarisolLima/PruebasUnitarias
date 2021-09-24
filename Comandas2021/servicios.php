<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo']) && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo']))
  {
     // Obtiene los datos del usuario
     $codigo  = $_SESSION['codigo'];
     $usuario = $_SESSION['usuario'];
     $tipo    = $_SESSION['tipo'];    

     // Verifica que el tipo sea atencion
     if ($tipo != "atencion")
     {
        // Variables para el error
        $titulo      = "Error Acceso";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }
  }
  else
  {
     // Variables para el error
     $titulo      = "Error Acceso";
     $descripcion = "Intento de Violación de Acceso";
     $enlace      = "index.php";

     // Lanzando Aplicación por Tipo
     header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Comandas Ver 2021</title>
  <!-- // Incluye bootstrap -->
  <?php include "bootstrap.html"; ?>
  <!-- // Incluimos las reglas de estilo de la aplicación--> 
  <link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />
</head>
<body>

  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Comandas-Servicios-Alta</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="comandas.php">
            Comandas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="entregas.php">
            Entregas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="php/salida.php">Salida</a>
        </li>    
      </ul>
    </div>  
  </nav>
  <br>

  <div class="container">
    <form action='php/servicioAlta.php' 
          class='was-validated' 
          method='POST'>

          <div class="form-group">
      
            <label for="idMesas">Selecciona la Mesa:</label>
            <select class="form-control" id="idMesas" name="mesa">
              <?php          
                // ejecuta la Consulta de Mesas Libres
                $mesasLibres = fnGetMesasLibres($conexion);

                // Ciclo para procesar cada registro de usario
                while ($fila = $mesasLibres->fetch_assoc()) 
                {
                   // Crea el elemento del Select
                   echo "<option>";
                   echo "[".$fila['numero']."]-".$fila['nombre'];
                   echo "</option>";          
                }
              ?>
            </select>

            <label for="idComensales">Selecciona Comensales:</label>
            <select class="form-control" id="idComensales" name="comensales">
                <option>1</option>                          
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>                          
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
            </select>        
          </div>
        <button type="submit" class="btn btn-success">Aceptar</button>
    </form>
    
  </div>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom">
    <button type="button" class="btn btn-warning">
          <?php 
            echo strtoupper($usuario);      
          ?>
    </button>
    <button type="button" class="btn btn-outline-warning">
          <?php 
            echo strtoupper($tipo);      
          ?> 
    </button>
    </nav>
</body>
</html>