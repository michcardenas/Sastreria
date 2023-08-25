$(document).ready(function(){ 

  $('#valor').on('blur', function() {
    // obtener el valor actual del campo
    var valor = $(this).val();

    // remover cualquier formato existente (puntos, comas y símbolo de moneda)
    valor = parseFloat(valor.replace(/[^0-9-.]/g, ''));

    // verificar si el valor es un número
    if (!isNaN(valor)) {
        // formatear el número
        valor = valor.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });

        // establecer el valor formateado de nuevo en el campo
        $(this).val(valor);
    }
});


$('#atras_confirm').on('click', function() {

  var confirma = confirm('¿Quieres salir sin facturar?');
  if (confirma) {
      window.location.href = 'calendario.php';
  } else {
      // El usuario hizo clic en Cancelar, puedes manejar esto aquí si es necesario
  }
});
$('#atras').on('click', function() {

  var confirma = confirm('¿Quieres salir sin guardar?');
  if (confirma) {
      window.location.href = 'calendario.php';
  } else {
      // El usuario hizo clic en Cancelar, puedes manejar esto aquí si es necesario
  }
});
  
  $('#guardarorden').on("click", function(){ 
    // campos del fomulario
    inputName = $('#txtname').val();
    txttel = $('#txttel').val();
    select_prenda = $('#select_prenda').val();
    otro = $('#otro').val();
    descripcion_arreglo = $('#descripcion_arreglo').val();    estimacion_min = $('#estimacion_min').val();
    valor = $('#valor').val();
    id = $('#id').val();
    estimacion_min = $('#estimacion_min').val();
    cantidad = $('#cantidad').val();
    if ( !select_prenda  || !descripcion_arreglo || !estimacion_min || !valor || !id || !cantidad) {
      alert('Todos los campos son requeridos');
      return;
  }
    var ruta = "/sas/ordenes/orden.php";
    var partes = ruta.split("/"); 
    var nombreDirectorio = partes[1]; 

    console.log(nombreDirectorio);
    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=guardarorden&nombre="+inputName+"&tel="+txttel+"&prenda="+select_prenda+"&otro="+otro+"&descripcion_arreglo="+descripcion_arreglo+"&valor="+valor+"&id="+id+"&estimacion_min="+estimacion_min+"&cantidad="+cantidad,
      dataType: "text",
      success: function(response) {
        console.log(response);
        if (response == 1) {
            var dialog = $("#dialog-confirm").dialog({
                autoOpen: false,
                closeOnEscape: false,
                height: "auto",
                width: 300,
                modal: true,
                buttons: {
                    "Confirmar": function() {
                      window.location.href = "?id="+id+"&mode=orden";
                    },
                    "Terminar": function() {
                      window.location.href = "../ordenes/total.php?id="+id;
                        
                    }
                }
            });
            dialog.dialog("open");
        }
    }
    
    
    });
  });
			


  $('#guardar_factura').on("click", function(){ 
    // campos del fomulario
    id_factura = $('#id_factura').val();
    id_cliente = $('#id_cliente').val();
    sub_total = $('#sub-total').val();
    fecha_entrega = $('#fecha_entrega').val();
    franja_horaria = $('#franja_horaria').val();    
    abono = $('#abono').val(); 
    valor_total = $('#valor_total').val(); 
    estimacion_total = $('#estimacion_total').val(); 
    factura_orden = $('#factura_orden').val();
    tipo_pago = $('#tipo_pago').val();
    cantidad = $('#prenda_totales').val();
  
    
    if (!id_factura ||  !sub_total || !fecha_entrega || !franja_horaria  || !valor_total || !estimacion_total ||  !tipo_pago || !cantidad) {
      alert('Todos los campos son requeridos');
      return;
  }
    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=guardar_factura&id_factura="+id_factura+"&id="+id_cliente+"&sub_total="+sub_total+"&fecha_entrega="+fecha_entrega+"&franja_horaria="+franja_horaria+"&abono="+abono+"&valor_total="+valor_total+"&estimacion_total="+estimacion_total+"&factura_orden="+factura_orden+"&tipo_pago="+tipo_pago+"&cantidad="+cantidad,
      dataType: "text",
      success: function(response) {
        console.log(response);
        if (response == 1) {
          window.location.href = 'detalle_orden.php?id_factura=' + encodeURIComponent(id_factura) + '&sub_total=' + encodeURIComponent(sub_total);
        }else{
          console.log("No se guardo");
        }
    }
    
    
    });
  });

  $('#entregar').on("click", function(){ 
    // campos del fomulario
    id_factura = $('#id_facturaa').val();
    fecha_actual = $('#fecha_actual').val();
    saldo = parseFloat($('#saldo').val().replace(/[$,.]/g, ''));
    abono = parseFloat($('#abono_inicial').val().replace(/[$,.]/g, ''));
    sub_total = parseFloat($('#sub-total').val().replace(/[$,.]/g, ''));
    
    total_cliente = saldo + abono;
    console.log(total_cliente);
    
if(total_cliente == sub_total){ 
  

    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=entregar&id_factura="+id_factura+"&fecha_actual="+fecha_actual+"&saldo="+saldo,
      dataType: "text",
      success: function(response) {
        console.log(response);
        if (response == 1) {
          window.location.href = '../ordenes/detalle_orden.php?id_factura=' + encodeURIComponent(id_factura);

        }else{
          console.log("No se guardo");
        }
    }
    
    
    });
  }else{
    alert('Campo saldo no debe ser menor al sub total');
  }
  });


  $('#actualizar_factura').on("click", function(){ 
    
    // campos del fomulario
    id_factura = $('#id_facturaa').val();
    abono = parseFloat($('#abono_inicial').val().replace(/[$,.]/g, ''));
    sub_total = parseFloat($('#sub-total').val().replace(/[$,.]/g, ''));
    total =parseFloat($('#valor_total').val().replace(/[$,.]/g, '')); 
    estado_factura  = $('#estado_factura').val();
    fecha_sin_hora  = $('#fecha_sin_hora').val();

    


    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=actualizar_factura&id_factura="+id_factura+"&sub_total="+sub_total+"&abono="+abono+"&total="+total+"&estado_factura="+estado_factura,
      dataType: "text",
      success: function(response) {
        console.log(response);
        if (response == 1) {
          window.location.href = '../calendario/detalle_orden.php?fecha='+fecha_sin_hora;
        }else{
          console.log("No se guardo");
        }
    }
    
    
    });
  });
  $('#actualizar_prenda').on("click", function(){ 
    
    // campos del fomulario
    prenda_id = $('#prenda_id').val();
    descripcion_arreglo = $('#descripcion_arreglo').val();
    valor = $('#valor').val();
    estimacion = $('#estimacion').val();
    estado = $('#estado').val();  
    id_cliente  = $('#id_cliente').val(); 
    factura  = $('#factura').val(); 
    estado_factura  = $('#estado_factura').val(); 
  factura  = $('#factura').val(); 
    
console.log(valor);
   
    console.log(estado_factura);
 

    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=actualizar_prenda&prenda_id="+prenda_id+"&descripcion_arreglo="+descripcion_arreglo+"&valor="+valor+"&estimacion="+estimacion+"&estado="+estado+"&estado_factura="+estado_factura+"&factura="+factura,
      dataType: "text",
      success: function(response) {
        console.log(response);
        if (response == 1) {
          alert('Se ha actualizado de forma correcta');
          window.location.href = '../calendario/detalle_cliente.php?id='+id_cliente+'&id_factura='+factura;
        }else{
          console.log("No se guardo");
        }
    }
    
    
    });
  }); 

  $('#facturar').on("click", function(){ 
    
    // campos del fomulario
    id_facturaa = $('#id_facturaa').val();
    tipo_pago = $('#tipo_pago').val();
    id_cliente = $('#id_cliente').val();

   

    

   


    if (confirm('¿Está seguro que desea facturar esta orden?')) {
      // Código que se ejecutará si el usuario selecciona "OK"
      $.ajax({
          type: "POST",
          url: "../callbacks/ordenes.php",
          data: "mode=facturar&id_facturaa="+id_facturaa+"&tipo_pago="+tipo_pago,
          dataType: "text",
          success: function(response) {
              console.log(response);
              if (response == 1) {
                  alert('Se ha actualizado de forma correcta');
                  window.location.href = '../ordenes/detalle_orden.php?id='+id_cliente+'&id_factura='+id_facturaa;
              }else{
                  console.log("No se guardo");
              }
          }
      });
  } else {
      // Código que se ejecutará si el usuario selecciona "Cancelar"
      console.log("Acción cancelada por el usuario");
  }
  
  }); 
  $('#search_value').on("click", function(){ 
    const inputTel = document.getElementById("txttel").value;
    inputName = $('#txtname').val();
    console.log(inputName);
    var datos = {
        "mode": "buscar_factura",
        "inputTel": inputTel,
        "inputName": inputName
    };
    
   
    $.ajax({
        data: datos,
        dataType: 'json',
        url: '../callbacks/clientes.php',
        type: 'POST',
        
        beforesend: function()
        {
            $('.loading').show();
            $('#mostrar_mensaje_error').hide();
            $('.tabla-clientes').hide();
        },
        error: function()
        {
          $('#mostrar_mensaje_error').html("<h5>Cliente no está registrado en nuestra base de datos</h5>");
              },
        success: function(valore) {
          if(valore.existe == 0) {
              $('#mostrar_mensaje_error').html("<h5> Cliente no esta registrado en nuestra base de datos</h5>");
              // Recarga la página después de mostrar el mensaje de error
          location.reload(); 
          } else {
            
              var tabla = "<table>";
              for (var i = 0; i < valore.valores.length; i++) {
                 if(valore.valores[i].estado == 0){
                  estado_final = "pendiente";
                  style_estado = "style ='color:#FC2947;'";
                 }
                 if(valore.valores[i].estado == 1){
                  estado_final = "Arreglado ";
                  style_estado = "style ='color:#7AA874;'";
                 }
                 if(valore.valores[i].estado == 2){
                  estado_final = "Entregado ";
                  style_estado = "style ='color:#2B3467;'";
                 }
                 if(valore.valores[i].estado == 3){
                  estado_final = "En proceso";
                  style_estado = "style ='color:#A4907C;'";

                 }
                 console.log(style_estado);
                  tabla += "<tr><td><strong>Nombre</strong></td><td><strong>Estado</strong></td><td><strong># Factura</strong></td></tr>";
                  tabla += "<tr><td><a href='facturar.php?id_factura=" + valore.valores[i].id + "&mode=orden'>" + valore.valores[i].nombre + "</a></td><td "+style_estado+" >" + estado_final + "</td><td>" + valore.valores[i].id + "</td></tr>";
             
                  


              }
              tabla += "</table>";
              $('#mostrar_mensaje').html(tabla);
          }
        }
        
      
      
      
        
      });
} );
   

    
    $('.loading').hide();

      $('#search').on("click", function(){ 
        const inputTel = document.getElementById("txttel").value;
        inputName = $('#txtname').val();
       
        var datos = {
            "mode": "buscar",
            "inputTel": inputTel,
            
            "inputName": inputName
        };
        
       
        $.ajax({
            data: datos,
            dataType: 'json',
            url: '../callbacks/clientes.php',
            type: 'POST',
            
            beforesend: function()
            {
                $('.loading').show();
                $('.tabla-clientes').hide();
            },
            error: function()
            {
              $('#mostrar_mensaje_error').html("<h5>Cliente no está registrado en nuestra base de datos</h5>");
            },
            success: function(valore) {
              console.log(valore.existe);
              if(valore.existe == 1) {

              $('#mostrar_mensaje_error').hide();
              if(valore.existe == 1) {
              var id = valore.id || "";
              var nombre = valore.nombre || "";
              var telefono = valore.telefono || "";
              $('#mostrar_mensaje').html("<table><tr><td><strong>Nombre</strong></td></tr><tr><td><a href='../ordenes/orden.php?id=" + id + "&mode=orden'>" + nombre + "</a></td></tr>").show();
              $('#mostrar_mensaje1').html("<tr><td><strong>Telefono</strong></td></tr><tr><td>"+telefono+"</td></tr> ").show();
              $('#mostrar_mensaje2').html("<tr><td><strong>Editar</strong></td></tr><tr><td><a href='../ordenes/editar_cliente.php?id=" + id + "'> <button type='button'  id='editar' class='button-buscar'>✏️</button></a></td></tr> </table>").show();

              }
            }
             else {
              $('#mostrar_mensaje').hide();
              $('#mostrar_mensaje1').hide();
              $('#mostrar_mensaje2').hide();
                $('#mostrar_mensaje_error').html("<h5> Cliente no esta registrado en nuestra base de datos</h5>").show();
              }
            }
            
          });
    } );
    
    $('#crear').on("click", (e) =>  {
      enviar();      
    });
   
    
    

    $('#regresar_orden').on("click", function(){ 
    
      window.location.href = "/clientes/clientes.php";

     
          
  });
  
//totatl orden
  $('#abono').on('change', function() {
   // obtener el valor actual del campo
   var valor = $(this).val();

   // remover cualquier formato existente (puntos, comas y símbolo de moneda)
   valor = parseFloat(valor.replace(/[^0-9-.]/g, ''));

   // verificar si el valor es un número
   if (!isNaN(valor)) {
       // formatear el número
       valor = valor.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });

       // establecer el valor formateado de nuevo en el campo
       $(this).val(valor);
   }
   resta_total_abono();
  });
  $('#saldo').on('change', function() {
    // obtener el valor actual del campo
    var valor = $(this).val();
 
    // remover cualquier formato existente (puntos, comas y símbolo de moneda)
    valor = parseFloat(valor.replace(/[^0-9-.]/g, ''));
 
    // verificar si el valor es un número
    if (!isNaN(valor)) {
        // formatear el número
        valor = valor.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });
 
        // establecer el valor formateado de nuevo en el campo
        $(this).val(valor);
    }
   
   });

  
  $('#sub-total').on('change', function() {
    resta_total_abono();
  });
  $('#abono_inicial').on('change', function() {
       // obtener el valor actual del campo
   var valor = $(this).val();

   // remover cualquier formato existente (puntos, comas y símbolo de moneda)
   valor = parseFloat(valor.replace(/[^0-9-.]/g, ''));

   // verificar si el valor es un número
   if (!isNaN(valor)) {
       // formatear el número
       valor = valor.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });

       // establecer el valor formateado de nuevo en el campo
       $(this).val(valor);
   }
    resta_total_abono_final();
  });
  
  
  
  
  
    function enviar(){
      const inputTel = document.getElementById("txttel").value;
      const inputName = document.getElementById("txtname").value;
      var datos = {
          "mode": "guardar",
          "inputTel": inputTel,
          "inputName": inputName
      };
      
     
      $.ajax({
          data: datos,
          dataType: 'text',
          url: '../callbacks/clientes.php',
          type: 'POST',
          error: function(request, status, error)
          {
            alert("ocurrio un error "+request.responseText)
            console.log(error)
          },
          success: function(data) {
            if(data == 1){ 
              $('#form').trigger('reset');
              $('#mostrar_mensaje').text('Se ha guardado correctamente');
            } else if(data ==0) {
              $('#mostrar_mensaje').text('Verifique la informacion, al parecer es cliente ya creado');
            }
          
        }
        });
  } 


 
      return false;
      function resta_total_abono() {
       var sub_total = $('#sub-total').val();
       var abono = $('#abono').val();
       var prueba = parseInt(abono.replace(/[^0-9]/g, ''))
        console.log(prueba);
        console.log(abono);
        // obtener el valor actual del campo y remover cualquier formato existente
        var sub_total = parseInt(sub_total.replace(/[^0-9]/g, '')) || 0;
        var abono =parseInt(abono.replace(/[^0-9]/g, '')) || 0;
        console.log(sub_total);
        console.log(abono);
        var valor_total = sub_total - abono;
        valor_total = valor_total.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });

        $('#valor_total').val(valor_total);
    } 
    
    function resta_total_abono_final() {
      var sub_total = $('#sub-total').val();
      var abono = $('#abono_inicial').val();
      var prueba = parseInt(abono.replace(/[^0-9]/g, ''))
       console.log(prueba);
       console.log(abono);
       // obtener el valor actual del campo y remover cualquier formato existente
       var sub_total = parseInt(sub_total.replace(/[^0-9]/g, '')) || 0;
       var abono =parseInt(abono.replace(/[^0-9]/g, '')) || 0;
       console.log(sub_total);
       console.log(abono);
       var valor_total = sub_total - abono;
       valor_total = valor_total.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });

       $('#valor_total').val(valor_total);
       $('#saldo').val(valor_total);
   } 








	
});
function goBack() {
  window.history.back();
}