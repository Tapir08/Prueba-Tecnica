<?php include "includes/config.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Transportes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./public/styles.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./public/logo.jpg" id="Logo" width="130" height="70" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <button id="abrir-formulario" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle" style="font-size: 1.5rem;"></i>
                        <span class="button-text" style="font-size: 1.2rem;">Agregar Nuevo Viaje</span>
                    </button>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div id="formulario" class="container mt-5">
    <h1 class="text-center mb-4">Lista de Viajes</h1>
    <div class="table-responsive shadow-lg rounded-4 p-3 bg-white">
        <table id="tabla-viajes" class="display table table-striped table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Fecha del viaje</th>
                    <th>Dirección de Origen</th>
                    <th>Comuna de Origen</th>
                    <th>Teléfono de Contacto</th>
                    <th>Dirección de Destino</th>
                    <th>Comuna de Destino</th>
                    <th>Teléfono Destino</th>
                    <th>Ejecutivo</th>
                    <th>Solicitante</th>
                    <th>Valor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
    <div id="editModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="edit-form">
                        <input type="hidden" id="edit-id" name="edit-id">
                        <div class="mb-3">
                            <label for="edit-fecha_viaje" class="form-label">Fecha del viaje</label>
                            <input type="date" class="form-control" id="edit-fecha_viaje" name="edit-fecha_viaje">
                        </div>

                        <div class="mb-3">
                            <label for="edit-origen_direccion" class="form-label">Direccion de Origen</label>
                            <input type="text" class="form-control" id="edit-origen_direccion" name="edit-origen_direccion">
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit-origen_comuna" class="form-label">Comuna de Origen</label>
                            <input type="text" class="form-control" id="edit-origen_comuna" name="edit-origen_comuna">
                        </div>

                        <div class="mb-3">
                            <label for="edit-origen_contacto" class="form-label">Telefono de Contacto</label>
                            <input type="text" class="form-control" id="edit-origen_contacto" name="edit-origen_contacto">
                        </div>

                        <div class="mb-3">
                            <label for="edit-destino_direccion" class="form-label">Direccion de Destino</label>
                            <input type="text" class="form-control" id="edit-destino_direccion" name="edit-destino_direccion">
                        </div>

                        <div class="mb-3">
                            <label for="edit-destino_comuna" class="form-label">Comuna de Destino</label>
                            <input type="text" class="form-control" id="edit-destino_comuna" name="edit-destino_comuna">
                        </div>

                        <div class="mb-3">
                            <label for="edit-destino_contacto" class="form-label">Telefono Destino</label>
                            <input type="text" class="form-control" id="edit-destino_contacto" name="edit-destino_contacto">
                        </div>

                        <div class="mb-3">
                            <label for="edit-usuario_ejecutivo" class="form-label">Ejecutivo</label>
                            <input type="text" class="form-control" id="edit-usuario_ejecutivo" name="edit-usuario_ejecutivo">
                        </div>

                        <div class="mb-3">
                            <label for="edit-usuario_solicitante" class="form-label">Solicitante</label>
                            <input type="text" class="form-control" id="edit-usuario_solicitante" name="edit-usuario_solicitante">
                        </div>

                        <div class="mb-3">
                            <label for="edit-valor" class="form-label">Valor</label>
                            <input type="number" class="form-control" id="edit-valor" name="edit-valor">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="edit-button">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleModalLabel">Detalles del viaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="map" style="height: 400px; width:100%"></div>
                    <p><i class="bi bi-geo"></i> <strong>  Distancia: </strong> <span id="distancia"></span></p>
                    <p><i class="bi bi-stopwatch"></i><strong>  Tiempo Estimado: </strong> <span id="tiempo"></span></p>

                </div>

            </div>
        </div>
    </div>


    <script src="./public/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo getenv('API_KEY'); ?>&libraries=places"></script>

</body>
</html>
