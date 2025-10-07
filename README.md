# proyecto-biblioteca
Tecnologías

- Docker
- PHP 8.3+
- Laravel 12
- MySQL / SQLite
- Livewire
- Tailwind CSS
  
1. Clona el repositorio:
   

git clone https://github.com/vanessadelvalleg/proyecto-biblioteca.git

cd proyecto-biblioteca


2. Copia el archivo de entorno:
   

cp .env.example .env

3. Edita .env para configurar la base de datos de Docker:
   

DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DB_DATABASE=biblioteca

DB_USERNAME=ubiblioteca

DB_PASSWORD=pbiblioteca

4. Correr composer
   

composer install

5. Levantar entorno con Docker
   

docker-compose up -d

6. Ejecuta migraciones y seeders:
   

php artisan migrate:fresh --seed


7. Compila los assets (Tailwind, JS, etc.):
   

para entrar al contenedor de la app

docker exec -it biblioteca_app bash

npm install

npm run dev


8. Para visualizar el proyecto


 http://localhost:8080


