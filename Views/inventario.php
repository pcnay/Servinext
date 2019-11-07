<?php
  /* 
  Cuando se agrega una opción al Menu se agregan los siguientes archivos.
  header.php (Donde se define la nueva opción del menú).
  Router.php (Se agregan las opciones de menu de “Usuarios”, se cargan las páginas.)

  Vistas :
  UsuariosModel.php
  UsuariosController.php
  Usuarios.php
  Usuarios-add.php
  Usuarios-edit.php
  Usuarios-del.php
  */

  print('<h2 class="p1">CAPTURA DE INVENTARIO</h2>');
  // Mostrara en pantalla todos el inventario de Lexmark en la pantalla
  $inventario_controller = new InventariosController();
  $inventario = $inventario_controller->get();
  // Devuelve un arreglo.
  if (empty($inventario))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN REFACCIONES</p>
      </div>
      ');
  }
  else
  {
    $template_inventario = '
      <label for="caja_busqueda">Buscar</label>
      <input type="text" name="caja_busqueda" id="caja_busqueda" placeholder = "Texto a Buscar"></input>
      <div class="item lista">
        <table>
          <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th>Num. Parte</th>
            <th>Existencia</th>
            <th>Fecha</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Observaciones</th>
            <th > <!-- <th colspan="2"> -->
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="inventarios-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>                            
            </th>
            <th>
            <!-- Boton Imprimir -->
            <form method="POST" > <!-- action ="./Reportes/reportes-marcas.php"> -->
              <input type="hidden" name="r" value="reportes-inventarios">
              <input class="button imprimir" type = "submit" value="Imprimir">      
            </form>              
            </th>

          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($inventario);$n++)
    {
      $template_inventario .='
         <tr>
          <td>'.$inventario[$n]['id_refaccion'].'</td>
          <td>'.$inventario[$n]['descripcion' ].'</td>
          <td>'.$inventario[$n]['num_parte' ].'</td>
          <td>'.$inventario[$n]['existencia' ].'</td>
          <td>'.$inventario[$n]['fecha' ].'</td>
          <td>'.$inventario[$n]['marca' ].'</td>
          <td>'.$inventario[$n]['modelo' ].'</td>
          <td>'.$inventario[$n]['observaciones' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="inventarios-edit">
              <input type="hidden" name="id_refaccion" value="'.$inventario[$n]['id_refaccion'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="inventarios-delete">
              <input type="hidden" name="id_refaccion" value="'.$inventario[$n]['id_refaccion'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_inventario .='       
        </table>
      </div>    
    ';
    print($template_inventario);

  }

?>


