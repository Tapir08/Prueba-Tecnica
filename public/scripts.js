
$(document).ready(function() {
    $('#tabla-viajes').DataTable({
        "ajax": "./api/load_viaje.php", 
        "columns": [
    { "data": "id" },
    { "data": "fecha_viaje" },
    { "data": "origen_direccion" },
    { "data": "origen_comuna" },
    { "data": "origen_contacto" },
    { "data": "destino_direccion" },
    { "data": "destino_comuna" },
    { "data": "destino_contacto" },
    { "data": "usuario_ejecutivo" },
    { "data": "usuario_solicitante" },
    { "data": "valor" },
    {
        "data": null,
        "render": function (data, type, row) {
    return `
<button class="btn btn-secondary editar-btn" data-id="${row.id}">
    <i class="bi bi-pencil"></i>
</button>
<button class="btn btn-danger eliminar-btn" data-id="${row.id}">
    <i class="bi bi-trash"></i>
</button>
<button class="btn btn-primary btn-detalle" 
    data-origen="${row.origen_direccion}" 
    data-origen-comuna="${row.origen_comuna}" 
    data-destino="${row.destino_direccion}" 
    data-destino-comuna="${row.destino_comuna}">
    <i class="bi bi-geo-alt"></i></button>
    `;
}

    }
],
"columnDefs": [
    { "targets": -1, "orderable": false } // Esto evita que la columna de botones sea ordenable
]
    });

    $('#tabla-viajes tbody').on('click', '.editar-btn', function() {
        var id = $(this).data("id");

        $.ajax({
            url : "./api/get_viaje.php", 
            type : "POST",
            data : { id: id },
            dataType : "json",
            success : function(response) {
                if(response) {
                    $("#edit-id").val(response.id);
                    $("#edit-fecha_viaje").val(response.fecha_viaje);
                    $("#edit-origen_direccion").val(response.origen_direccion);
                    $("#edit-origen_comuna").val(response.origen_comuna);
                    $("#edit-origen_contacto").val(response.origen_contacto);
                    $("#edit-destino_direccion").val(response.destino_direccion);
                    $("#edit-destino_comuna").val(response.destino_comuna);
                    $("#edit-destino_contacto").val(response.destino_contacto);
                    $("#edit-usuario_ejecutivo").val(response.usuario_ejecutivo);
                    $("#edit-usuario_solicitante").val(response.usuario_solicitante);
                    $("#edit-valor").val(response.valor);

                    // Mostrar el modal
                    $("#editModal").modal("show");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#tabla-viajes tbody').on('click', '.eliminar-btn', function() {
        let id = $(this).data('id');
        eliminarViaje(id);
    });


    $('#tabla-viajes tbody').on('click', '.btn-detalle', function () {
        let origen = $(this).data("origen") + ", " + $(this).data("origen-comuna") + ", Chile";
        let destino = $(this).data("destino") + ", " + $(this).data("destino-comuna") + ", Chile";
    
        console.log("Origen: ", origen);
        console.log("Destino: ", destino);
    
        $("#detalleModal").modal("show");
    
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: { lat: -33.4489, lng: -70.6693 }
        });
    
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);
    
        directionsService.route({
            origin: origen,
            destination: destino,
            travelMode: "DRIVING",
        }, function (response, status) {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
                $("#distancia").text(response.routes[0].legs[0].distance.text);
                $("#tiempo").text(response.routes[0].legs[0].duration.text);
            } else {
                alert("No se pudo calcular la ruta, revisa las direcciones");
            }
        });
    });
    

    function eliminarViaje(id) {
        Swal.fire({
            title: "¿Seguro que quieres eliminar este viaje?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("./api/delete_viaje.php", { id: id }, function(response) {
                    Swal.fire({
                        title: "Eliminado!",
                        text: response,
                        icon: "success"
                    });
                    $('#tabla-viajes').DataTable().ajax.reload();
                });
            }
        });
    }
    

    // Evento click para el botón "Guardar Cambios"
    $(document).on("click", "#edit-button", function () {
        var id = $("#edit-id").val();
        var fecha = $("#edit-fecha_viaje").val();
        var origen = $("#edit-origen_direccion").val();
        var comuna = $("#edit-origen_comuna").val();
        var contacto = $("#edit-origen_contacto").val();
        var destino = $("#edit-destino_direccion").val();
        var comuna_destino = $("#edit-destino_comuna").val();
        var telefono_destino = $("#edit-destino_contacto").val();
        var ejecutivo = $("#edit-usuario_ejecutivo").val();
        var solicitante = $("#edit-usuario_solicitante").val();
        var valor = $("#edit-valor").val();

        console.log({
            id: id,
            fecha_viaje: fecha,
            origen_direccion: origen,
            origen_comuna: comuna,
            origen_contacto: contacto,
            destino_direccion: destino,
            destino_comuna: comuna_destino,
            destino_contacto: telefono_destino,
            usuario_ejecutivo: ejecutivo,
            usuario_solicitante: solicitante,
            valor: valor
        });

        $.ajax({
            url : "./api/update_viaje.php", 
            type : "POST",
            data : {
                id : id,
                fecha_viaje : fecha,
                origen_direccion : origen,
                origen_comuna : comuna,
                origen_contacto : contacto,
                destino_direccion : destino,
                destino_comuna : comuna_destino,
                destino_contacto : telefono_destino,
                usuario_ejecutivo : ejecutivo,
                usuario_solicitante : solicitante,
                valor : valor
            },
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                Swal.fire({
                    title: "Actualizado Correctamente",
                    text: response,
                    icon: "success"
                });
                $('#editModal').modal('hide'); // Ocultar el modal después de guardar
                $('#tabla-viajes').DataTable().ajax.reload(); // Recargar la tabla
            }
            ,
            error: function(xhr, status, error) {
                console.error("Error en AJAX:", error);
                Swal.fire({
                    title: "¡Error!",
                    text: "Hubo un problema al actualizar el viaje",
                    icon: "error"
                });
            }
            
        });
    });

    $("#abrir-formulario").click(function() {
        Swal.fire({
            title: 'Agregar nuevo Viaje',
            html: `
                <form id="nuevo-viaje-form">
                
                    <label for="fecha_viaje">Fecha del Viaje:</label>
                    <input type="date" id="fecha_viaje" name="fecha_viaje" class="swal2-input" required>
    
                    <label for="origen_direccion">Dirección de Origen:</label>
                    <input type="text" id="origen_direccion" name="origen_direccion" class="swal2-input" required>
    
                    <label for="origen_comuna">Comuna de Origen:</label>
                    <input type="text" id="origen_comuna" name="origen_comuna" class="swal2-input" required>
    
                    <label for="origen_contacto">Contacto de Origen:</label>
                    <input type="text" id="origen_contacto" name="origen_contacto" class="swal2-input" required>
    
                    <label for="destino_direccion">Dirección de Destino:</label>
                    <input type="text" id="destino_direccion" name="destino_direccion" class="swal2-input" required>
    
                    <label for="destino_comuna">Comuna de Destino:</label>
                    <input type="text" id="destino_comuna" name="destino_comuna" class="swal2-input" required>
    
                    <label for="destino_contacto">Contacto de Destino:</label>
                    <input type="text" id="destino_contacto" name="destino_contacto" class="swal2-input" required>
    
                    <label for="usuario_ejecutivo">Usuario Ejecutivo:</label>
                    <input type="text" id="usuario_ejecutivo" name="usuario_ejecutivo" class="swal2-input" required>
    
                    <label for="usuario_solicitante">Usuario Solicitante:</label>
                    <input type="text" id="usuario_solicitante" name="usuario_solicitante" class="swal2-input" required>
    
                    <label for="valor">Valor:</label>
                    <input type="number" id="valor" name="valor" class="swal2-input" required>
                </form>
            `,
            focusConfirm: false,
            width: '400px',
            showCancelButton: true,
            confirmButtonText: 'Crear Viaje',
            confirmButtonColor: "#3085d6",
            preConfirm: () => {
                // Recopilar los datos del formulario
                const fecha_viaje = document.getElementById('fecha_viaje').value;
                const origen_direccion = document.getElementById('origen_direccion').value;
                const origen_comuna = document.getElementById('origen_comuna').value;
                const origen_contacto = document.getElementById('origen_contacto').value;
                const destino_direccion = document.getElementById('destino_direccion').value;
                const destino_comuna = document.getElementById('destino_comuna').value;
                const destino_contacto = document.getElementById('destino_contacto').value;
                const usuario_ejecutivo = document.getElementById('usuario_ejecutivo').value;
                const usuario_solicitante = document.getElementById('usuario_solicitante').value;
                const valor = document.getElementById('valor').value;
                
                if (!fecha_viaje || !origen_direccion || !origen_comuna || !origen_contacto ||
                    !destino_direccion || !destino_comuna || !destino_contacto ||
                    !usuario_ejecutivo || !usuario_solicitante || !valor) {
                    Swal.showValidationMessage('Por favor, complete todos los campos requeridos');
                }
                
                return {
                    fecha_viaje,
                    origen_direccion,
                    origen_comuna,
                    origen_contacto,
                    destino_direccion,
                    destino_comuna,
                    destino_contacto,
                    usuario_ejecutivo,
                    usuario_solicitante,
                    valor
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
               
                $.ajax({
                    url: "./api/add_viaje.php",
                    type: "POST",
                    data: result.value,
                    success: function(response) {
                        Swal.fire({
                            title: "Éxito!",
                            text: response,
                            icon: "success"
                        });
                        $('#tabla-viajes').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo agregar el viaje",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
    
});