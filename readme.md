## Acerca de.

Con una instalación de Laravel 5.4 como base, agrega los paquetes de laravel socialite y laravel echo
- [Socialite](https://github.com/laravel/socialite)
- [Echo](https://laravel.com/docs/5.4/broadcasting#installing-laravel-echo)

## Instrucciones:

- Generar el app key con php artisan key:generate
- Copiar .env.example a .env (cp .env.example .env)
- Correr "composer install" para agregar los paquetes de vendors
- Correr "npm install" para agregar a node_modules las dependncias de laravel y laravel echo.
- Sacar una app en facebook para poner los datos en el archivo .env
- Sacar una app en pusher para poner los datos en el archivo .env
- Correr "npm run dev" para que agregue a la carpeta public los archivos de javascript.
