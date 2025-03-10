# Codection - La red social para desarrolladores

### Comandos Útiles:
- php artisan serve --host codection-project-posts.com
- npm run dev
- php artisan lang:publish


## ¿Cómo logré crear el módulo de Seguidores y Seguidos?

1. Creamos el controlador: *php artisan make:migration* create_followers_table
2. Generamos el usuario seguidor 'user_id' y el usuario que sigue 'follower_id'
3. Corremos el comando para migrar la tabla: *php artisan migrate*
4. Definir la relación UnoaMuchos en la clase del usuario
5. Creamos un controlador: php artisan make:controller FollowController

<!-- TODO: hacer la pagína 404 not found -->