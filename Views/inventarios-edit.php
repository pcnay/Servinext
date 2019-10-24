<?php
  $refaccion_controller = new InventariosController();

if(($_POST['r']=='inventarios-edit') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{  
  $refaccion = $refaccion_controller->get($_POST['id_refaccion']); // Obtiene el registro de la refaccion en cuestion, viene del formulario de Refacción, cuando se muestran todos.
        
  if (empty($refaccion))
  {
    
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTE LA REFACCION<b>%s</b></p>          
      </div>
      
      <script>
        window.onload = function()
        {
          reloadPage("inventarios")
        }
      </script>
      
    ';
    printf($template,$_POST['id_refaccion']);
  }
  else
  {
    // Se debe traer los datos de la pantalla para poder editarlo.
    // Asignado el valor de "radio" para ser desplegado.
    // $perfil_admin = ($usuario[0]['perfil']=='Admin')? 'checked':' ';
    // $perfil_user = ($usuario[0]['perfil']=='User')? 'checked':' ';

    // Va obtener las marcas de la base de datos.
    $marcas_controller = new MarcasController();
    $marcas = $marcas_controller->get(); 
    // Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
    $marcas_select = '';
    for ($n=0; $n<count($marcas); $n++)
    {
      // Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
      // $inventario[0]['id_marca'] = Proviene de la tabla Inventario de la base de datos
      //$marcas[$n]['id_marca'] = Proviene de la tabla Marcas de la base de datos
      $selected = ($refaccion[0]['id_marca']==$marcas[$n]['id_marca']) ? 'selected':'';

      $marcas_select .= '<option value ="'.$marcas[$n]['id_marca'].'"'.$selected.'>'.$marcas[$n]['descripcion'].'</option>';
    }

    // Va obtener los Modelos de la base de datos.
    $modelos_controller = new ModelosController();
    $modelos = $modelos_controller->get(); 
    // Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
    $modelos_select = '';
    for ($n=0; $n<count($modelos); $n++)
    {
      // Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
      // $inventario[0]['id_modelo'] = Proviene de la tabla Inventario de la base de datos
      //$marcas[$n]['id_modelo'] = Proviene de la tabla Marcas de la base de datos
      $selected = ($refaccion[0]['id_modelo']==$modelos[$n]['id_modelo']) ? 'selected':'';

      $modelos_select .= '<option value ="'.$modelos[$n]['id_modelo'].'"'.$selected.'>'.$modelos[$n]['descripcion'].'</option>';
    }    

    $template_inventario = ' 
      <h2 class= "p1">Editar Refacción</h2>
      <form method = "POST" class = "item">
        <div class="p_25">
          <!-- Es el campo llave de la tabla, por esta razon esta deshabilitado-->
          <input type="hidden" name="id_refaccion" value = "%s">
          <input type="text" placeholder="id_refaccion" value="%s" disabled required>                    
        </div>

        <div class="p_25">
          <input type="text" name="descripcion" placeholder="Descripcion" value="%s" required> 
        </div>
        <div class="p_25">
          <input type="text" name="num_parte" placeholder="Numero De Parte" value="%s" required> 
        </div>
        <div class="p_25">
          <input type="number" name="existencia" placeholder="Existencia" value="%s" required> 
        </div>
        <div class="p_25">
          <input type="date" name="fecha" placeholder="Fecha captura" value="%s" required> 
        </div>
        <!-- Se forma el comboBox para las "Marcas" -->
        <div class = "p_25">            
          <select name="id_marca" placeholder="Marcas" required>
            <option value="">Marcas</option>
            %s
          </select>
        </div>
        <!-- Se forma el comboBox para las "Modelo" -->
        <div class = "p_25">            
          <select name="id_modelo" placeholder="Modelos" required>
            <option value="">Modelo</option>
            %s
          </select>
        </div>
        <div class = "p_25">
          <textarea name="observaciones" cols="120" rows="10" placeholder="Observaciones" >%s</textarea>
        </div>         

        <div class="p_25">
          <input class ="button edit" type = "submit" value="Editar"> 
          <input type="hidden" name = "r" value = "inventarios-edit">          
          <input type="hidden" name = "crud" value = "set">
        </div>
      </form>
    ';

  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='usuarios-edit') ...
   printf (
    $template_inventario,
    $refaccion[0]['id_refaccion'],
    $refaccion[0]['id_refaccion'],
    $refaccion[0]['descripcion'],
    $refaccion[0]['num_parte'],
    $refaccion[0]['existencia'],
    $refaccion[0]['fecha'],
    $marcas_select,
    $modelos_select,
    $refaccion[0]['observaciones']
  );
 }

}

 else if ( ($_POST['r']=='inventarios-edit') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
 {
   // Se programa la inserción de datos, de los datos capturados del usuario.
   $salvar_refaccion = array(
    'id_refaccion' => $_POST['id_refaccion'],
    'descripcion' => $_POST['descripcion'],
    'num_parte' => $_POST['num_parte'],
    'existencia' => $_POST['existencia'],
    'fecha' => $_POST['fecha'],
    'id_marca' => $_POST['id_marca'],
    'id_modelo' => $_POST['id_modelo'],
    'observaciones' => $_POST['observaciones']
   );

   $refaccion = $refaccion_controller->set($salvar_refaccion);
   $template = '
     <div class="container">
       <p class="item edit">Refacción <b>%s</b> Guardado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Refacción nuevamente.
         reloadPage("inventario")
       }       
     </script>
   '; 
   printf($template,$salvar_refaccion['descripcion']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>
