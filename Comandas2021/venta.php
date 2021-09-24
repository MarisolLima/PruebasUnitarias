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
     if ($tipo != "control")
     {
        // Variables para el error
        $titulo      = "Error Acceso Venta";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }
  }
  else
  {
     // Variables para el error
     $titulo      = "Error Acceso Venta";
     $descripcion = "Intento de Violación de Acceso. Falta de Datos";
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
  <script type="text/javascript">
    function printHTML() 
    { 
      if (window.print) 
      { 
        window.print();
      }
    }
  </script>
</head>
<body>

  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Comandas-Venta</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="usuarios.php">
            Usuarios 
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mesas.php">
            Mesas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="clases.php">
            Clases
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comentarios.php">
            Comentarios
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">
            Productos
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

    <form class='was-validated'>
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <table class="table table-striped table-light">
              <thead class="thead-dark">
                <tr>
                    <th>Serv</th>
                    <th>Hora</th>
                    <th>Mesa</th>
                    <th>Mese</th>
                    <th>Come</th>
                    <th style="text-align: right">Total</th>
                </tr>
              </thead>
              <tbody>

              <?php  
                  // Variable para la Suma Total
                  $sumaTotales = 0;

                  // Obtiene los Productos de Cocina a Preparar
                  $registros = fnGetVentaDia($conexion,$codigo);
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Coloca los datos en variables
                      $servicio   = $fila["numero"];
                      $hora       = $fila["hora"];
                      $mesa       = $fila["mesa"];
                      $mesero     = $fila['mesero'];
                      $comensales = $fila['comensales'];
                      $total      = $fila['total'];

                      // Agrega a la suma
                      if (is_numeric($total))
                        $sumaTotales+=$total;

                      // Crea un row
                      echo "<tr> \n";
                      
                      // Coloca los datos                      
                      echo "<td>";
                      echo "<a class='btn btn-success' href='ventaServicio.php?servicio=$servicio'>";
                      echo $servicio;
                      //echo "</a>";
                      echo "</td>\n";
                      
                      echo "<td>".substr($hora,0,5)."</td>\n";
                      echo "<td>$mesa</td>\n";
                      echo "<td>$mesero</td>\n";
                      echo "<td>$comensales</td>\n";
                      echo "<td align=right>$total</td>\n";

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }
              ?>
              </tbody>
            </table>  
          </div>
          <?php
              echo "<p align=right class='bg-warning text-white'>&nbsp&nbspTotal: ".number_format($sumaTotales,2)."&nbsp&nbsp&nbsp</p>\n";
          ?>
        <button onclick="printHTML()" class="btn btn-success">Imprimir</button>        
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