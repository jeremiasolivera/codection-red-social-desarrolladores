# CODECTION - Red Social Para Desarrolladores

<p align="center">
  <img src="https://i.ibb.co/cKTCNFpT/logo-2-codection.jpg" width="200">
</p>

Codection surge como una iniciativa inspirada en DailyDev, una popular red social para desarrolladores de habla inglesa.

  

Codection tiene como objetivo proporcionar un espacio donde los usuarios puedan compartir sus experiencias cotidianas en el ámbito tecnológico, colaborar con otros profesionales y mantenerse actualizados con las últimas novedades del sector.
  

## 🚀 Uso

Codection está diseñado para personas hispanohablantes interesadas en la tecnología.

Los usuarios podrán iniciar sesión con un solo clic, realizar publicaciones, interactuar con

ellas y crear grupos de interés para intercambiar ideas con otros profesionales.

  

## ✨ Tecnologías utilizadas

-  **Backend**: Laravel

-  **Frontend**: Blade + Tailwind CSS

-  **Base de datos**: MySQL

-  **Autenticación**: Laravel Breeze y Socialite

  

## ⚙️ Instalación

1. Clonar el repositorio:

```bash

git clone https://github.com/jeremiasolivera/codection-red-social-desarrolladores

cd codection

```

2. Instalar dependencias:

```bash

composer install

npm install

```

3. Copiar el archivo de entorno:

```bash

cp .env.example .env

```

4. Configurar la base de datos en `.env` y ejecutar:

```bash

php artisan migrate --seed

```

5. Generar la clave de aplicación:

```bash

php artisan key:generate

```

6. Iniciar el servidor:

```bash

php artisan serve

```

7. Compilar assets:

```bash

npm run dev

```

## 🌟 Entregables

-  **Inicio de sesión con Google y GitHub**: SingleSign-On con Google y GitHub.

-  **Plataforma de Publicaciones y Conexiones entre Usuarios**: Sistema de likes y reposts.

-  **Grupos de Interés**:Los usuarios podrán crear grupos enfocados en un tema principal.

  

## ⚖️ Licencia

Este proyecto es de código abierto y fue creado para poner en práctica mis habilidades.

  

---

👏 **Desarrollado con pasión por Jeremías Olivera, Téc. Analista de Sistemas.**
