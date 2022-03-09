Spotify App
==================

API para consultar discografía por artista desde spotify

Requisitos
----

* PHP 7.4+
* PHP cURL
* Node with npm

Instalación
----

Ejecutar

    composer install 

Luego de esto, ejecutar las dependencias para ejecutar webpack

    npm install
    
    npm run build

Finalmente iniciar el servidor 

    symfony server:start

Configuración
----

En la raiz del proyecto modificar las variables de entorno de session de spotify, Client Id y Client Secret (Los valores por defecto sirven para realizar pruebas) en el fichero .env:

```dotenv
SPOTIFY_CLIENT_ID=fad982f0a029456a966efd41e4f014ec
SPOTIFY_CLIENT_SECRET=82825c82636c4054a8d05b467458fd9f
```

Uso
----

Acceder a la documentación de los Endpoints

    http://localhost:8000/api/

Buscar la lista de albums por artista

    http://localhost:8000/api/v1/albums?q=<band-name>

El API soporta el formato jsonld por lo que si se requiere información mas detallada de la petición se debera agregar la extension

    http://localhost:8000/api/v1/albums.jsonld?q=<band-name>

Para obtener información en el formato json

    http://localhost:8000/api/v1/albums.json?q=<band-name>

Se puede controlar el limite de items esperados y la página a traves de los parametros limit y page:

    http://localhost:8000/api/v1/albums.json?q=<band-name>&limit=<limit-per-page>&page=<page>


Test
----

Se han implementado test Unitarios, para ejecutarlos desde la consola ejecutar:

    php bin\phpunit