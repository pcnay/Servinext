<?php
  $refaccion_controller = new InventariosController();

if(($_POST['r']=='inventarios-delete') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $refaccion = $refaccion_controller->get($_POST['id_refaccion']); // Obtiene el registro de la refacción en cuestion, viene del formulario de Inventarios (boton eliminar), cuando se muestran todos.
  if (empty($refaccion))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTE LA REFACCION <b>%s</b></p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("inventario")
        }
      </script>
    ';
    printf($template,$refaccion[0]['descripcion']); // $_POST['usuario']);
  }
  else
  {
    // Realiza la pregunta si se desea eliminar
    $template_refaccion = ' 
      <h2 class = "p1">Eliminar Usuario</h2>
      <form method="POST" class="item">
        <div class="p1 f2"><!-- Aumenta el doble la letra -->
          Estas Seguro de eliminar la refaccion :<mark class="p1">%s</mark>          
        </div>
        <div class="p_25">
          <input class="button delete" type ="submit" value = "SI">
          <!-- Regresa a la página anterior -->
          <input class="button add" type ="button" value = "NO" onclick="history.back()">
          <input type ="hidden" name="id_refaccion" value = "%s">
          <input type ="hidden" name="r" value = "inventarios-delete">
          <input type ="hidden" name="crud" value = "del">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='inventarios-delete') ...
   printf (
      $template_refaccion,
      $refaccion[0]['descripcion'],
      $refaccion[0]['id_refaccion']      
    );
 }

}
 else if ( ($_POST['r']=='inventarios-delete') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='del'))
 {
   // Se programa el borrado de la refaccion
 
    $refaccion = $refaccion_controller->del($_POST['id_refaccion']); // $refaccion[0]['id_refaccion']); //$_POST['id_refaccion']);
   $template = '
     <div class="container">
       <p class="item delete">Refaccion <b>%s</b> Borrado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Inventarios nuevamente.
         reloadPage("inventario")
       }       
     </script>
   '; 
   printf($template,$refaccion[0]['descripcion']);//$_POST['descripcion']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>
