----------Introducción----------

Como entorno de desarrollo se utilizo XAMPP, como un entorno de desarrollo local, además se incluyeron algunas tecnologías de front-end, además de las solicitadas, las cuales serian Bootstrap,DataTables y Sweet-Alert para darle mas dinamismo e interacción a la app.

----------Instalación----------

1.-Como se menciono anteriormente se utilizo XAMPP mas los servicios de Apache y MySQL, por lo que para que el proyecto funcione se debe copiar la carpeta a la ruta de instalación de XAMPP, en mi caso : "C:\xampp\htdocs\transportes-panel".

2.-Para continuar con la instalación del proyecto se debe abrir phpMyAdmin e importar el archivo de transportes.sql.


----------Configuración API Key----------

1.-Obtención de la API Key
	-Dirigirse a Google Cloud Console
	-Crear un proyecto y dirigirse al Menu de navegacion, y hacer click en APIs y Servicios.
	-habilitar la Google Maps JavaScript API, junto con Geocoding API y Directions API.
	-Se generara una API Key, la cual deberá copiarse e ingresarse en el .env
2.-Configuración de la BD.
	-para configurar la DB, se deben ingresar los siguientes datos al .env, el host ( el cual seria localhost), el usuario, contraseña, y el nombre de la db (trasportes).

----------Uso de la Aplicación----------


1.-Acceso al Panel Principal
   -la aplicación consta de una sola pagina, la cual seria  http://localhost/transportes-panel/index.php.

2.-Lista de Viajes
	-Se muestra una tabla con todos los registros de los viajes
	-El apartado acciones en cada columna permite al usuario, editar, eliminar y ver los detalles del viaje.


3.-Agregar un nuevo Viaje:
	-Al hacer click en el botón + en el extremo derecho de la NavBar se abrirá un formulario, que requerirá llenar los campos, gracias a AJAX la tabla se actualizara en tiempo real.

4.-Ver Detalles:
	-Como se menciono anteriormente en el apartado de listas de viajes, se permite ver los detalles de viaje gracias a la implementación de la API de google, también se estima el tiempo que se demorara y los Kilometros recorridos.
