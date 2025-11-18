📁 Sistema de Archivo Municipal – Municipalidad Distrital de Guadalupe

Gestión de tomos físicos, documentos digitalizados, series documentales y áreas productoras.

Este sistema permite administrar el Archivo Municipal de la MDG, reemplazando la gestión manual realizada mediante archivos Excel y documentos físicos. Está construido con Laravel 12, MySQL, TailwindCSS y Sanctum para autenticación API.

🚀 Funcionalidades principales
🔐 Autenticación y seguridad

Inicio de sesión para usuarios autorizados (sin registro público).

Roles: Super-admin, Administrador, Archivista, Consulta.

Control de acceso por permisos Spatie.

🗂️ Áreas del archivo

Gestión de las áreas productoras: Secretaría General, RRHH, Gerencias, etc.

Cada documento y tomo pertenece a un área.

🧩 Series documentales

Clasificación archivística para agrupar tomos de la misma temática.

Series y subseries opcionales.

📚 Tomos físicos

Registro de tomos del archivo físico:

Item (autogenerado)

Área

Año

Número de tomo

Folios totales (calculados automáticamente)

Rango de documentos: desde / hasta

Ubicación física (andamio, fila)

Estado (activo / inactivo)

Lista de tomos con búsqueda por área, año, serie, etc.

📄 Documentos digitalizados

Registro de resoluciones, acuerdos, expedientes, etc.

Campos:

Área

Número de documento

Nombre / descripción

Fecha

Folio dentro del tomo

Archivo PDF o imagen (opcional)

Relación automática al tomo y actualización de:

Cantidad de folios

Documento inicial «desde»

Documento final «hasta»

🔎 Consulta rápida de documentos

Búsqueda por:

Número de documento

Área

Tomo

Año

Serie documental

Descarga del PDF cuando exista.

🖥️ Panel administrativo moderno

Diseño con Tailwind y Blade.

Interfaz especializada para archivistas.

🛠️ Tecnologías utilizadas
Componente	Versión
Laravel	12.x
PHP	8.2 o superior
MySQL	8.x
TailwindCSS	3.x
Laravel Breeze	Para login
Laravel Sanctum	Para API
Spatie Roles & Permissions	Control de acceso
📦 Instalación (local)
# Clonar el repositorio
git clone https://github.com/Benja0501/Archivo-municipalidad.git
cd sistema-archivo-mdg

# Instalar dependencias
composer install
npm install
npm run build

# Copiar archivo de entorno
cp .env.example .env

# Generar llave
php artisan key:generate

# Configurar base de datos en .env
# luego:
php artisan migrate --seed

Crear usuario administrador

El seed crea un usuario:

Usuario: admin@archivo-muni.test
Contraseña: password
Rol: Super-admin


Puedes cambiarlo desde el panel.

🌐 Rutas principales
Panel administrativo
/admin

Dashboard general
/dashboard

Gestión de usuarios
/admin/users

Gestión de áreas
/admin/areas

Series documentales
/admin/series

Tomos físicos
/admin/tomos

Documentos digitalizados
/admin/documentos

🔌 API básica (Laravel Sanctum)
Obtener usuario autenticado
GET /api/me
Header: Authorization: Bearer {token}

Cerrar sesión
POST /api/logout

📁 Estructura del proyecto
app/
 ├── Http/Controllers/Admin/...
 ├── Models/
 ├── Policies/
database/
 ├── migrations/
 ├── seeders/
resources/
 ├── views/admin/...
 ├── views/tomos/
 ├── views/documentos/
 ├── views/areas/
 ├── views/series/
 ├── views/auth/
routes/
 ├── web.php
 ├── api.php

☁️ Deploy en hosting/cPanel (paso a paso)
1. Subir los archivos del proyecto

Sube todo excepto /vendor.

Sube dentro de una carpeta: sistema-archivo o similar.

2. Instalar dependencias vía terminal de cPanel
composer install --no-dev
npm install && npm run build (opcional si tu hosting soporta node)

3. Configurar .env

Base de datos del hosting

URL del dominio

Credenciales de correo (si usarás notificaciones)

4. Mover el contenido de /public a la raíz web (/public_html)

O apuntar el dominio a /public.

5. Migrar base de datos
php artisan migrate --seed

6. Configurar permisos
chmod -R 775 storage bootstrap/cache

🏛️ Créditos

Desarrollado para el Archivo Municipal – Municipalidad Distrital de Guadalupe (MDG).
Diseño adaptado a la identidad institucional.

📸 Capturas de pantalla

..

📄 Licencia

Este software es propiedad de la Municipalidad Distrital de Guadalupe.
Queda prohibida su distribución sin autorización institucional.