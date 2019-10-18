<?php 
// Valida que sea la opción de "inventarios-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
// User = Solo podra ver información.


if ($_POST['r']== 'inventarios-add' && $_SESSION['perfil'] == 'Admin' && !isset($_POST['crud']))
{
  // Obtener las marcas
  $marcas_controller = new MarcasController();
  $marcas = $marcas_controller->get();
  $marcas_select = '';
  for ($n=0;$n<count($marcas);$n++)
  {
    $marcas_select .= '<option value = "'.$marcas[$n]['id_marca'].'">'.$marcas[$n]['descripcion'].'</option>';
  }
    
  // Obtener los modelos
  $modelos_controller = new ModelosController();
  $modelos = $modelos_controller->get();
  $modelos_select = '';
  for ($n=0;$n<count($modelos);$n++)
  {
    $modelos_select .= '<option value = "'.$modelos[$n]['id_modelo'].'">'.$modelos[$n]['descripcion'].'</option>';
  }

  printf('
    <h2 class = "p1">Agregar Refaccion Lexmark</h2>

    <!-- Se agrega el formulario para la captura de las Refacciones de Lexmark -->
    <form method="POST" class="item">
      <div class="p_25">
        <input type = "text" name="descripcion" placeholder="Capturar La Descripcion">
      </div>
      <div class="p_25">
        <input type = "text" name="num_parte" placeholder="Numero De Parte">
      </div>
      <div class="p_25">
        <input type = "number" name="existencia" placeholder="Existencia" required>
      </div>
      <div class="p_25">
        <input type = "text" name="fecha" placeholder="Fecha De Captura">
      </div>

      <div class="p_25">
        <select name="id_marca" placeholder="Marca" required>
          <option value = "">Marca</option>
          %s
        </select>
      </div>
      <div class="p_25">
        <select name="id_modelo" placeholder="Modelo" required>
          <option value = "">Modelo</option>
          %s
        </select>
      </div>

      <div class="p_25">
        <textarea name="observaciones" cols="120" rows = "10" placeholder="Observaciones"></textarea>
      </div>

      <div class="p_25">
        <input class="button add" type="submit" value="Agregar">
        <input type="hidden" name="r" value="inventarios-add">
        <input type="hidden" name="crud" value="set">
      </div>
    </form>
  ',$marcas_select,$modelos_select);
}
// Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
else if ($_POST['r']== 'inventarios-add' && $_SESSION['perfil'] == 'Admin' && $_POST['crud'] == 'set')
{
  // programar la inserción de los datos
  $inventarios_controller = new InventariosController();
  $new_inventario = array(
    'id_refaccion'  => 0, // Para que se autoincremente este número, partiendo del que esta actualmente
    'descripcion' => $_POST['descripcion'],
    'num_parte' => $_POST['num_parte'],
    'existencia' => $_POST['existencia'],
    'id_marca' => $_POST['id_marca'],
    'id_modelo' => $_POST['id_modelo'],
    'observaciones' => $_POST['observaciones']
  );
  
  $inventarios = $inventarios_controller->set($new_inventario); // Graba a la Tabla de "t_Refaccion" lo que tecleo el usuario.

  $template = '
    <div class = "container">
      <p class = "item add">Refaccion <b>%s </b> Guardado En La Base De Datos </p>
    </div>
    <script>
      window.onload = function()
      {
        reloadPage("inventario")
      }

    </script>

  ';
  printf($template,$_POST['descripcion']);
}
else
{
  // Para generar la vista de NO autorizado.
  $controller = new ViewControllers();
  $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
}
?>





















