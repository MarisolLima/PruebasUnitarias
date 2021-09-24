<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo'])  && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo']))
  {
     // Obtiene los datos del usuario
     $codigo   = $_SESSION['codigo'];
     $usuario  = $_SESSION['usuario'];
     $tipo     = $_SESSION['tipo'];             

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
     else
     {
        // Verifico que venga servicio y mesa por GET
        if (!isset($_GET["servicio"]) ||
            !isset($_GET["mesa"]))
        {
           // Variables para el error
           $titulo      = "Error Acceso";
           $descripcion = "Intento de Violación de Acceso por Información";
           $enlace      = "index.php";

           // Lanzando Aplicación por Tipo
           header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
        }
        else
        {
           // Obtiene la Mesa y El Servicio
          $servicio = $_GET["servicio"];
          $mesa     = $_GET["mesa"];
        }
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
    <a class="navbar-brand" href="#">
       <?php
          echo "Comandas-Cobrar";
       ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="servicios.php">
            Servicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comandas.php">
            Comandas
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
    <form action='php/servicioCobro.php' 
          class='was-validated' 
          method='POST'>
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <?php
               echo "<input type='hidden' name='servicio' value='$servicio'>";
               echo "<input type='hidden' name='mesa' value='$mesa'>";
               echo "<p class='bg-warning text-white'>&nbsp&nbspServicio: $servicio Mesa: $mesa </p>\n";                            
            ?>

            <table class="table table-striped table-light">
              <thead class="thead-dark">
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                </tr>
              </thead>
              <tbody>

              <?php  
                  // Variable para el Total
                  $total = 0;

                  // Obtiene los registros
                  $registros = fnGetServicioCobrar($conexion,$codigo,$servicio);
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Crea un row
                      echo "<tr> \n";
                    
                      // Coloca los datos
                      echo "<td>".$fila['producto']."</td>\n";
                      echo "<td>".$fila['nombre']."</td>\n";
                      echo "<td align=right>".$fila['cantidad']."</td>\n";
                      echo "<td align=right>".$fila['precio']."</td>\n";
                      echo "<td align=right>".$fila['importe']."</td>\n";

                      // Incremento el Total
                      $total += $fila['importe'];

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }

              ?>
              </tbody>
            </table>  
            <?php
               echo "<input type='hidden' name='total' value='$total'>";
               echo "<p align=right class='bg-warning text-white'>&nbsp&nbspTotal: ".number_format($total,2)."&nbsp&nbsp&nbsp</p>\n";
               
               $registros = fnGetServicioCobrar($conexion,$codigo,$servicio);
            ?>            
          </div>
        <button type="submit" class="btn btn-success">Aceptar</button>
        <a class="btn btn-warning" href="atencion.php" role="button">Regresar</a>
  </div>

  <br><br><br>
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