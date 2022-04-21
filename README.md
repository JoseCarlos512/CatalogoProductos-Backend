
## DEPLOY
Si deseamos desplegar el proyecto en algun servidor dejare un video de
referencia que utilice para desplegar mi proyecto en Heroku.


Se creo primero que todo fichero Procfile



**************************************
*     Application In Production!     *
**************************************
- php artisan migrate (Subir las tablas desde laravel a la bd)
- php artisan db:seed (compilar los seeders que son la informacion creada)
- php artisan migrate:refresh (eliminar las tablas creadas y volver a compilar)

https://www.youtube.com/watch?v=GE2Kmy8WL3g


## Ante posibles errores revisar esta rama de starkoverflow
- Se comento el storage para hacer un deploy de la aplicacion en heroku
- #/storage/*.key
https://stackoverflow.com/questions/64456175/a-post-autoload-dump-script-terminated-with-an-error

