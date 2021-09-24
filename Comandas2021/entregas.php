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
        $titulo      = "Error de Acceso: Entregas";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }     
  }
  else
  {
     // Variables para el error
     $titulo      = "Error de Acceso: Entregas";
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
          echo "Comandas-Entregas";
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
    <form>
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <table class="table table-striped table-light">
              <thead class="thead-dark">
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Mesa</th>
                    <th>Cantidad</th>
                </tr>
              </thead>
              <tbody>

              <?php  

                  // Obtiene los Productos a Entregar del usuario
                  $registros = fnGetProductosAEntregar($conexion,$codigo);
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Coloca los datos en variables
                      $servicio = $fila["servicio"];
                      $comanda  = $fila["numero"];
                      $producto = $fila["producto"];
                      $nombre   = $fila['nombre'];
                      $cantidad = $fila['cantidad'];

                      // Crea un row
                      echo "<tr> \n";

                      // Coloca los datos
                      echo "<td>";
                      echo "<a class='btn btn-success' href='php/productoEntregado.php?servicio=$servicio&comanda=$comanda&producto=$producto'>";
                      echo $fila['producto'];
                      echo "</td>\n";
                      echo "<td>".$fila['nombre']."</td>\n";
                      echo "<td>".$fila['mesa']."</td>\n";   
                      echo "<td align=right>".$fila['cantidad'];
                      echo "</td>\n";

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }
              ?>
              </tbody>
            </table>  
          </div>
        <a class="btn btn-warning" href="entregas.php" role="button">Actualizar</a>
      </form>
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