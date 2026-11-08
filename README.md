# Ayúdanos a Ayudar

Prototipo académico para gestión de un albergue de perros. Laravel 12, PHP 8.2+, MySQL 8, Blade y CSS local. No requiere Node para servir la interfaz: los recursos están en public/css y public/js.

## Instalación

1. Ejecutar `composer install`.
2. Copiar `.env.example` a `.env` y configurar una base MySQL vacía con DB_CONNECTION=mysql, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME y DB_PASSWORD.
3. Ejecutar `php artisan key:generate` y `php artisan migrate`.
4. Solo en desarrollo: `php artisan db:seed`.
5. Ejecutar `php artisan serve --port=8011` y abrir http://127.0.0.1:8011.

Para una demostración sin MySQL se puede usar DB_CONNECTION=sqlite y crear database/database.sqlite. Las migraciones son compatibles con ambos motores. Las pruebas usan SQLite en memoria y no borran la base MySQL.

## Cuentas de demostración

Solo para desarrollo: admin@demo.test, volunteer@demo.test, supporter@demo.test. Contraseña común: DemoLocal!2026. El seeder bloquea su ejecución en production. Nunca desplegar estas cuentas conocidas con datos reales.

## Funcionalidades

- Catálogo público filtrable por tamaño y fichas visibles/ocultas.
- Registro, login limitado por intentos, logout e invalidación de sesión.
- CRUD administrador de perros, necesidades y aportes.
- Solicitudes de adopción propias; prevención de duplicados; revisión humana.
- Aprobación de adopción transaccional con bloqueo del perro.
- Intención de donación sin cobro; recepción confirmada por administrador.
- Postulación de voluntariado y asignación del rol al aprobar.
- Registro e historial de cuidados para administrador y voluntario.
- Privacidad, validación en español y diseño móvil.

## Arquitectura y seguridad

routes/web.php → middleware de sesión y rol → controladores → ShelterService → Eloquent → MySQL. Blade escapa las entradas y los formularios llevan CSRF. El registro público no acepta role. El servidor asigna user_id y el estado inicial de las solicitudes. Las imágenes de la portada son una ilustración SVG original; las fichas usan marcadores hasta disponer de fotografías autorizadas. No se implementa carga de fotos, correo de recuperación de contraseña, pagos ni agenda de turnos.

## Pruebas

`php artisan test`: nueve pruebas, 48 aserciones en la verificación inicial. Cubren acceso por rol, registro sin elevación de privilegios, CRUD de tres entidades, validación, escape XSS, solicitudes, donaciones y cuidados. En Windows, PHP puede necesitar una ruta sin acentos para PHPUnit. No son una auditoría de seguridad exhaustiva.

## Publicación en alwaysdata

Crear otra base y otro sitio para este proyecto. No sobrescribir el Gestor de tareas anterior. Configurar PHP compatible, raíz del sitio apuntando a public, instalar con `composer install --no-dev --optimize-autoloader`, crear .env con APP_ENV=production, APP_DEBUG=false, APP_LOCALE=es y APP_URL=https://DOMINIO. Configurar MySQL, generar APP_KEY una sola vez, ejecutar `php artisan migrate --force` y `php artisan optimize`. Crear el administrador con una contraseña privada; no ejecutar el seeder de demostración. No publicar .env ni database.sqlite.

## Conservación de datos

No se elimina un perro con solicitudes o cuidados: se oculta para conservar historial. Revisar manualmente cada adopción antes de aprobar. Una aprobación de voluntariado concede el rol; rechazar una postulación posteriormente no revoca automáticamente el rol ya concedido. La revocación administrativa y gestión avanzada de usuarios quedan para una siguiente iteración.

Respaldar MySQL antes de migraciones, guardar copia cifrada fuera del servidor y probar restauración. Definir responsable y política de retención con el albergue antes de recoger datos reales.

## Licencias y autoría

Laravel y sus componentes mantienen sus licencias originales en vendor. Dependencias exactas en composer.lock. Revisar `composer licenses` antes de distribuir. Código específico generado con asistencia de IA y pendiente de revisión y atribución por el equipo académico. No se atribuyen commits ni entrevistas ficticias. Las contribuciones reales del equipo deben registrarse desde sus propias cuentas.

Documentación: https://laravel.com/docs/12.x/authentication y https://laravel.com/docs/12.x/validation.
