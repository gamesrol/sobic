
     ######   #######  ########  ####  ######   ®
    ##    ## ##    ### ##     ##  ##  ##    ## 
    ##       ##   # ## ##     ##  ##  ##       
     ######  ##  #  ## ########   ##  ##       
          ## ## #   ## ##     ##  ##  ##       
    ##    ## ###    ## ##     ##  ##  ##    ## 
     ######   #######  ########  ####  ######  

================================================

## 1. Introducción

Sobic es un framework basado en el patrón Modelo-Vista-Controlador que combina los lenguajes PHP y AngularJS.


## 2. Requisitos de Sobic:

 - Apache2.
 - PHP 5.5 o superior, aunque se recomienda tener la última versión.
 - Composer instalado en el sistema o en la carpeta.
 - Activar la extensión de PDO en PHP para el acceso a bases de datos.
 - Gestor de bases datos como MySQL, Oracle SQL, SQLite, etc.
 - Activar los módulos de PHP mod_rewrite y cURL.

## 3. Estructura de Sobic

Sobic tiene una estructura de carpetas y archivos básica que ha de ser respetada para el correcto funcionamiento de una aplicación desarrollada con Sobic. La estructura es la siguiente:
  
 - App. 
    En la carpeta “App” se almacenan los archivos que se podrían denominar como la api del servicio, es el software que se ejecuta en el servidor y que se comunica con la base de datos y gestiona la información y como esta es tratada y almacenada. Contiene los controladores, las rutas y los modelos.
 - Config.
    Contiene los archivos de configuración de la base de datos y el estado de la plataforma.
 - Database.
    En la carpeta “Database” se almacenan los archivos que contienen el conjunto de operaciones que se pueden realizar en la base de datos, operaciones tales como las migraciones o las semillas.
 - Public.
    La carpeta “Public” corresponde con el “front-end” o la parte visible de la aplicación, es el software que ejecuta el cliente y que le añade estilo y ordena la información mostrada y proveída por la api o “back-end”. Contiene las imágenes mostradas, las librerías y fuentes, los estilos CSS, etc.
 - Vendor.
    La carpeta “Vendor” incluye los componentes utilizados por el sistema Sobic, también se incluyen aquí los complementos o plugins así como todo el software de terceros utilizado. Es una carpeta auto-generada por Composer al instalarse junto con otros componentes esenciales como Slim o Eloquent. No se recomienda modificar el contenido ya existente de esta carpeta, si se añade algún componente aparecerá aquí el nuevo.

 - Composer.json.
 - Composer.lock.
 - Sobic.

Por último se encuentran tres ficheros de configuracion, “composer.json”, “composer.lock” y “sobic”.

Los dos primeros pertenecen a composer y el último es el alma de sobic, en el se almacenan las operaciones que crearán todo el sistema, se recomienda no modificar ninguno de estos tres archivos.


## 4. Comenzando con Sobic

Descargar el git desde la dirección de Sobic en github (https://github.com/gamesrol/sobic/ "Sobic") y guardalo en la raíz del servidor web. A continuación se actualiza "Composer" con el comando:
    
    composer install
    
Una vez realizada la tarea y con el sistema gestor de base de datos configurado, se modificará el acceso a la misma para que conecte satisfactoriamente, para esto Sobic ofrece varios entornos de producción. 
En la carpeta "config" y gestionado por el archivo "enviroment.php" se establece el estado de la plataforma entre desarrollo, prueba y producción, en cada uno podemos tener una base de datos diferente. Cada uno tiene su archivo donde establecer las variables de entorno y se hace de la siguiente manera:

     $capsule->addConnection(array(          
     	'driver'    => 'mysql',                      //Llamamos al driver que conecta con la base de datos.
	     'host'      => getenv('IP'),            //Establecemos el host de la base de datos.
     	'port'      => 3306,                         //Seleccionamos el puerto de connexión.
	     'database'  => 'c9',                    //Indicamos el nombre de la base de datos a utilizar.
     	'username'  => getenv('C9_USER'),            //Usuario de la base de datos.
     	'password'  => '',                           //Password del usuario.
     	'prefix'    => '',                           //Indicamos el prefijo
     	'charset'   => "utf8",                       //Se indica el juego de carácteres.
     	'collation' => "utf8_unicode_ci"
     ));

 - Nota 1: El ejemplo utilizado es para un sistema implementado en c9.io, por eso se deja la contraseña en blanco, recuerda cambiarla antes de publicar el trabajo.
 - Nota 2: Ya que el ORM utilizado es ELOQUENT, la estructura y sentencias utilizadas es la misma que podemos encontrar en la documentación oficial de ELOQUENT. 

Ahora se puede comenzar a introducir las diferentes instrucciones de Sobic, pero antes de hacer ninguna prueba recuerda que la configuración de acceso web se hace desde el archivo '.htaccess' ubicado en la raíz y por defecto, si se accede directamente a la carpeta "/public", invocará un error 404.

## 5. Instrucciones de Sobic

#### 5.1 Creación de migraciones: 
Las migraciones son un tipo de control de versiones para la base de datos. Hace posible que los diferentes miembros del equipo modifiquen la estructura de la base de datos y que el resto de miembros esten informados sobre el estado actual. 
Para crear una migración introduce la siguiente orden en consola:

    php sobic create migrate [name]

Ejemplo:

     php sobic create migrate shop "string('name')" "integer('price')" [...]

Se creará un archivo parecido a este "app/database/migrations/ExamplesMigration.php".

#### 5.1.2 Ejecutar la migración: 
Inicializará la base de datos con la estructura existente, en el caso de no haber creado previamente una migración se ejecutará la migraciones por defecto.

    php sobic migrate [name]
    
Ejecuta la migraci&oacute;n nombrada, para realizar más de una introduce los nombres por orden de las relaciones.    
Al ejecutar una migración creada por defecto se borrará la tabla de la base de datos y se volverán a crear, por lo que los datos se perderán, para evitar esto comenta o borra esta línea dentro del archivo "NameMigration.php":

    Capsule::schema()->dropIfExists('name');

#### 5.2 Creación de Seed y Poblado de datos:
Crea una semilla que poblará la base de datos con datos de prueba.

    php sobic create seed [name]

Se creará un archivo parecido a este "app/database/seeds/ExamplesSeed.php".

#### 5.3 Creación de Modelos: 
El Modelo es la representación de la información con la cual el sistema opera, por lo tanto gestiona todos los accesos a dicha información, tanto consultas como actualizaciones, implementando también los privilegios de acceso que se hayan descrito en las especificaciones de la aplicación (lógica de negocio).
Para crear un modelo introducimos la siguiente orden:

    php sobic create model [name] [atributo:nombre_atributo],[..,]
 
Ejemplo:

     php sobic create model shop "string('name')" "integer('price')" [...]
    
Se creará un archivo parecido a este "app/models/Examples.php".

Después de crear un modelo ha de actualizarse composer, para cargar el modelo creado, introduciendo:
    
    composer dump-autoload

#### 5.4 Creación de Controladores: 
El controlador responde a eventos (usualmente acciones del usuario) e invoca peticiones al 'modelo' cuando se hace alguna solicitud sobre la información (por ejemplo, editar un documento o un registro en una base de datos).
Para crear un controlador introducimos la siguiente orden:

    php sobic create controller [name]
    
Se creará un archivo parecido a este "app/controllers/example.php".

#### 5.5 Creación de Scaffold: 
La orden Scaffold genera una estructura base de una aplicación con todas las instrucciones anteriormente descritas.
Para crear un controlador introducimos la siguiente orden:

    php sobic create scaffold [name] [arguments],[..,]

Ejemplo:

     php sobic create scaffold shop "string('name')" "integer('price')" [...]

Durante la creación del scaffold se modifican los siguientes archivos:
 
 - En "app/main.php" bajo la etiqueta "/** Scaffold PHP Controller **/" donde se añade el método "include" con la ubicación del controlador.
 - En "public/js/main.js" bajo la etiqueta "/* Es importante que estas lineas siempre esten al final para que funcione el scaffolg. */" donde se indica la ubicación de los controladores.
 - En "public/partials/layout.html" bajo las etiquetas "< !-- Scaffold JS -- >" y "< !-- Scaffold HTML -- >" donde primeramente se carga la libreria js y después se crea el enlace en la vista HTML.

Después de crear un modelo ha de actualizarse composer, para cargar el modelo creado, introduciendo:
    
    composer dump-autoload

También hay que ejecutar la migración que se creó con el scaffold, con el siguiente comando:

    php sobic migrate [--seed]


#### 5.6 Creación de Vistas: 
La vista presenta el 'modelo' (información y lógica de negocio) en un formato adecuado para interactuar (usualmente la interfaz de usuario) por tanto requiere de dicho 'modelo' la información que debe representar como salida.
Para crear un controlador introducimos la siguiente orden:

    php sobic create views [name] [atributo:nombre_atributo],[..,]
    
Se crearán los siguientes archivos y directorios:
 
 - public/partials/example
 - public/partials/example/form.html
 - public/partials/example/form.html
 - public/js/controllers/example
 - public/js/controllers/example/form.js
 - public/js/controllers/example/show.js

## 6. Recomendaciones

#### 6.1 Se recomienda que en caso de implementar la gestion de usuarios proporcionada, se haga sobre el protocolo HTTPS y no sobre HTTP.


## 7. Licencia

Sobic ha sido desarrollado bajo licencia MIT.

Sobic utiliza los siguientes frameworks:

 - Illuminate con Slim y Eloquent pertenecientes al framework Laravel registrado bajo <a href="https://es.wikipedia.org/wiki/Licencia_MIT"> licencia MIT. </a> 
 - Composer como gestor de dependencias, publicado bajo <a href="https://es.wikipedia.org/wiki/Licencia_MIT"> licencia MIT. </a>

## 8. Desarrolladores

 - Gustavo Adolfo Mesa Roldán (Idea, coordinación y desarollo)
 - Daniel rodriguez (Desarrollo, testing y documentacion)
