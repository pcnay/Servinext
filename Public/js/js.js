$(buscar_datos());
function buscar_datos(consulta)
{
  $.ajax({
    url:'buscar.php',
    type:'POST',
    dataType:'html',
    data:{consulta:consulta},
  })
  .done(function(respuesta){
    // En ests parte agrega lo que encontro n el DIV "lista"
    $(".lista").html(respuesta);
  })
  .fail(function(){
    console.log("error");
  })
}
$(document).on ('keyup','#caja_busqueda',function(){
  var valor = $(this).val();
  if (valor != "")
  {
    buscar_datos(valor);
  }
  else
    {
      buscar_datos();
    }
});

function reloadPage(url)
 {
   setTimeout(function (){
    // Recarga la página que se indica en "url" después de 3 seg. La URL son las rutas amigables del menú general.
		window.location.href = url
  }, 3000);
}


