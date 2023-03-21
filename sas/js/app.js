$(document).ready(function(){ 
  
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

    var ruta = "/sas/ordenes/orden.php";
    var partes = ruta.split("/"); 
    var nombreDirectorio = partes[1]; 

    console.log(nombreDirectorio);
    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=guardarorden&nombre="+inputName+"&tel="+txttel+"&prenda="+select_prenda+"&otro="+otro+"&descripcion_arreglo="+descripcion_arreglo+"&valor="+valor+"&id="+id+"&estimacion_min="+estimacion_min,
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

    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=guardar_factura&id_factura="+id_factura+"&id="+id_cliente+"&sub_total="+sub_total+"&fecha_entrega="+fecha_entrega+"&franja_horaria="+franja_horaria+"&abono="+abono+"&valor_total="+valor_total+"&estimacion_total="+estimacion_total+"&factura_orden="+factura_orden,
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

  $('#actualizar_factura').on("click", function(){ 
    
    // campos del fomulario
    id_factura = $('#id_facturaa').val();
    sub_total = $('#sub-total').val();
    abono = $('#abono').val();
    total = $('#valor_total').val();
    estado = $('#estado').val();    
    fecha_sin_hora  = $('#fecha_sin_hora').val();

    console.log(id_factura);
    console.log(sub_total);
    console.log(abono);
    console.log(total);
    console.log(estado);


    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=actualizar_factura&id_factura="+id_factura+"&sub_total="+sub_total+"&abono="+abono+"&total="+total+"&estado="+estado,
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
    

   
    console.log(prenda_id);
    console.log(descripcion_arreglo);
    console.log(valor);
    console.log(estimacion);
    console.log(estado);
    console.log(id_cliente);

    $.ajax({
      type: "POST",
      url: "../callbacks/ordenes.php",
      data: "mode=actualizar_prenda&prenda_id="+prenda_id+"&descripcion_arreglo="+descripcion_arreglo+"&valor="+valor+"&estimacion="+estimacion+"&estado="+estado,
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

   

    
    $('.loading').hide();

      $('#search').on("click", function(){ 
        const inputTel = document.getElementById("txttel").value;
        inputName = $('#txtname').val();
        console.log(inputName);
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
              var id = valore.id || "";
              var nombre = valore.nombre || "";
              var telefono = valore.telefono || "";
              $('#mostrar_mensaje').html("<table><tr><td><strong>Nombre</strong></td></tr><tr><td><a href='../ordenes/orden.php?id=" + id + "&mode=orden'>" + nombre + "</a></td></tr></table>");
              $('#mostrar_mensaje1').html("<table><tr><td><strong>Telefono</strong></td></tr><tr><td>"+telefono+"</td></tr></table>");
              if(valore.existe == 0) {
                $('#mostrar_mensaje_error').html("<h5> Cliente no esta registrado en nuestra base de datos</h5>");
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
  $('#abono').on('change', function() {
    resta_total_abono();
  });
  
  $('#sub-total').on('change', function() {
    resta_total_abono();
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
  }     return false;
  function resta_total_abono() {
    var abono = parseFloat($('#abono').val()) || 0;
    var sub_total = parseFloat($('#sub-total').val()) || 0;
    var valor_total = sub_total - abono;
    $('#valor_total').val(valor_total);
  }

  


 






	
});
