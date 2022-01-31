Spotify App
==================

Aplicación para listar últimos lanzamientos en Spotify e información de artistas

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

La aplicación provee dos rutas para consumir información de Spotify.

Lanzamientos que lista los ultimos lanzamientos en spotify

    http://127.0.0.1:8000/lanzamientos

Artista que mostrará información detallada del artista. {id} será el identificador único de Spotify del artista. Se acceden desde el link en la lista de lanzamientos

    http://127.0.0.1:8000/artista/{id}



