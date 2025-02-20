**Aplicación Amigo Invisible**

Le he quitado la carpeta vendor y node_modules, las regeneras con
- composer install
- npm install

Revisa el fichero .env
Mira el pequeño cambio en package.json (la linea de añadir ...33.20)
Usa el fichero arranque.bat para ejecutar la aplicación y fijate que use el puerto 8000, si no, reinicia la máquina virtual.


Carga los datos iniciales con la instrucción
- php artisan migrate:fresh --seed

Comandos nuevos:
- php artisan make:request StoreGrupoRequest
- php artisan make:controller --invokable SorteoController
# TeamReviewer
