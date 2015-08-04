
     ######   #######  ########  ####  ######   ®
    ##    ## ##    ### ##     ##  ##  ##    ## 
    ##       ##   # ## ##     ##  ##  ##       
     ######  ##  #  ## ########   ##  ##       
          ## ## #   ## ##     ##  ##  ##       
    ##    ## ###    ## ##     ##  ##  ##    ## 
     ######   #######  ########  ####  ######  


## 0. Índice

#### 1. Introducción.
#### 2. Requisitos de Sobic.
#### 3. Estructura de Sobic.
#### 4. Comenzando con Sobic.
#### 5. Instrucciones de Sobic.
####    5.1 Migraciones.
####        5.1.2 Ejecución de Migraciones.
####    5.2 Poblado de datos.
####    5.3 Modelos.
####    5.4 Controladores.
####    5.5 Scaffold.
####    5.6 Vistas.
#### 6. Recomendaciones.
#### 7. Licencia.
#### 8. Contacto con los desarrolladores.



## 1. Introducción

Sobic es un framework basado en el patrón Modelo-Vista-Controlador que combina los lenguajes PHP y AngularJS. Sobic ha sido y continua siendo desarrollado por NextSun Limited.


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

Descargar el git desde la dirección de Sobic en github (https://github.com/gamesrol/Sobic/ "Sobic") y guardalo en la raíz del servidor web. A continuación se actualiza "Composer" con el comando:
    
    composer install/update
    
Una vez realizada la tarea se podrá comenzar a introducir las diferentes instrucciones de sobic.

## 5. Instrucciones de Sobic

#### 5.1 Creación de migraciones: 
Las migraciones son un tipo de control de versiones para la base de datos. Hace posible que los diferentes miembros del equipo modifiquen la estructura de la base de datos y que el resto de miembros esten informados sobre el estado actual. 
Para crear una migración introduce la siguiente orden en consola:

    php sobic create migrate [name]

Se creará un archivo parecido a este "app/database/migrations/ExamplesMigration.php".

#### 5.1.2 Ejecutar la migración: 
Inicializará la base de datos con la estructura existente, en el caso de no haber creado previamente una migración se ejecutará la migraciones por defecto.

    php sobic migrate

#### 5.2 Creación de Seed y Poblado de datos:
Crea una semilla que poblará la base de datos con datos de prueba.

    php sobic create seed [name]

Se creará un archivo parecido a este "app/database/seeds/ExamplesSeed.php".

#### 5.3 Creación de Modelos: 
El Modelo es la representación de la información con la cual el sistema opera, por lo tanto gestiona todos los accesos a dicha información, tanto consultas como actualizaciones, implementando también los privilegios de acceso que se hayan descrito en las especificaciones de la aplicación (lógica de negocio).
Para crear un modelo introducimos la siguiente orden:

    php sobic create model [name] [atributo:nombre_atributo],[..,]
    
Se creará un archivo parecido a este "app/models/Examples.php".

Después de crear un modelo ha de actualizarse composer, para cargar el modelo creado, introduciendo:
    
    composer dump-autoload

#### 5.4 Creación de Controladores: 
El controlador responde a eventos (usualmente acciones del usuario) e invoca peticiones al 'modelo' cuando se hace alguna solicitud sobre la información (por ejemplo, editar un documento o un registro en una base de datos).
Para crear un controlador introducimos la siguiente orden:

    php sobic create controller [name] [atributo:nombre_atributo],[..,]
    
Se creará un archivo parecido a este "app/controllers/example.php".

#### 5.5 Creación de Scaffold: 
La orden Scaffold genera una estructura base de una aplicación con todas las instrucciones anteriormente descritas.
Para crear un controlador introducimos la siguiente orden:

    php sobic create scaffold [name] [arguments],[..,]

Durante la creación del scaffold se modifican los siguientes archivos:
 
 - En "app/main.php" bajo la etiqueta "/** Scaffold PHP Controller **/" donde se añade el método "include" con la ubicación del controlador.
 - En "public/js/main.js" bajo la etiqueta "/* Es importante que estas lineas siempre esten al final para que funcione el scaffolg. */" donde se indica la ubicación de los controladores.
 - En "public/partials/layout.html" bajo las etiquetas "< !-- Scaffold JS -- >" y "< !-- Scaffold HTML -- >" donde primeramente se carga la libreria js y después se crea el enlace en la vista HTML.
  
Después de crear un scaffold ha de actualizarse composer para cargar el modelo creado y realizar una migración para actualizar la base de datos.

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

Sobic ha sido desarrollado por el equipo de NextSun UK Limited, bajo licencia MIT.

Sobic utiliza los siguientes frameworks:

 - Illuminate con Slim y Eloquent pertenecientes al framework Laravel registrado bajo <a href="https://es.wikipedia.org/wiki/Licencia_MIT"> licencia MIT. </a> 
 - Composer como gestor de dependencias, publicado bajo <a href="https://es.wikipedia.org/wiki/Licencia_MIT"> licencia MIT. </a>

## 8. Desarrolladores
Idea and implementation by:

 - Gustavo Adolfo Mesa Roldán

Supported by:

 - Daniel rodriguez (Assistant, something more than itching code & doc, corrections and moral support)
 - Rafael Bustamante (Manager, css artist and moral support)