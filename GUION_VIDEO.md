# Guion del video: Ayúdanos a Ayudar
Duración objetivo: 4 minutos y 30 segundos. Participan Nelson Augusto Bustinza Huamani y Juan Manuel Perea Bayona.

## Antes de grabar
Abre http://127.0.0.1:8011 y prepara una ventana privada para el colaborador. Prueba los pasos una vez. Graba pantalla y voz; evita mostrar .env, contraseñas o datos privados. Usa datos de demostración. Las cuentas locales están en README.md. No ejecutes eliminaciones sobre información real.

## 0:00–0:30 | Nelson | Presentación e inicio
“Somos Nelson Augusto Bustinza Huamani y Juan Manuel Perea Bayona. Presentamos Ayúdanos a Ayudar, un prototipo web para organizar información de un albergue, solicitudes de adopción, necesidades y colaboración. Este proyecto corresponde al curso Programación Web, a cargo del docente Victor Alfonzo Cornejo Arismendi.”

## 0:30–1:00 | Nelson | Catálogo público
Desplázate hasta las tres fotos y filtra por tamaño.
“El visitante puede consultar fichas publicadas y filtrar por tamaño. Estas fotografías y fichas son ilustrativas para la demostración; no afirmamos que correspondan a animales del albergue. También mostramos necesidades y una opción para colaborar.”

## 1:00–1:40 | Nelson | Colaborador
Entra como colaborador, abre Mi espacio, completa y envía una solicitud para un perro disponible. Muestra su estado.
“El usuario registrado puede solicitar una adopción, ofrecer apoyo o postular al voluntariado. La solicitud queda pendiente de evaluación; enviarla no significa que la adopción esté aprobada. Cada persona consulta sus propios registros. Los aportes se registran como intenciones de ayuda: esta web no procesa pagos.”

## 1:40–2:50 | Juan Manuel | Administración y CRUD
En otra ventana entra como administrador. En Perros crea una ficha llamada Prueba de video, edita su descripción y elimínala. Mantén esa ficha sin solicitudes ni cuidados. Repite brevemente crear, editar y eliminar una necesidad de prueba y un aporte de prueba; prepara los textos para no perder tiempo.
“La administración permite crear, consultar, actualizar y eliminar perros, necesidades y aportes. La información se guarda en la base de datos. Para conservar el historial no se permite eliminar perros que ya tienen solicitudes o cuidados; en esos casos se puede ocultar su publicación.”

## 2:50–3:20 | Juan Manuel | Evaluación y cuidados
Abre Solicitudes y cambia la solicitud de prueba a en revisión. Muestra Cuidados.
“El administrador evalúa las solicitudes. Los voluntarios autorizados pueden registrar actividades de cuidado. Los permisos distinguen administrador, voluntario y colaborador.”

## 3:20–4:00 | Juan Manuel | Validación, móvil y código
Intenta guardar un formulario administrativo con un campo obligatorio vacío. Reduce el ancho de la ventana. Muestra brevemente las carpetas app/Models, app/Http/Controllers, resources/views y el repositorio.
“Utilizamos Laravel con arquitectura MVC y MySQL. Los formularios se validan en el servidor, las contraseñas se almacenan mediante hash y se aplican protección CSRF y permisos por rol. La interfaz se adapta a pantallas pequeñas. El repositorio contiene el código y las instrucciones de instalación.”

## 4:00–4:30 | Ambos | Cierre
“El prototipo permite demostrar los procesos principales con datos de prueba. La entrevista grabada se incorporará como evidencia y sus resultados servirán para contrastar las necesidades y mejorar la aplicación. Entre las mejoras futuras están la carga de fotos propias y las notificaciones. Gracias.”
Si ya se analizó la entrevista al grabar, sustituye esa frase por un hallazgo real y la función que lo atiende; no inventes respuestas.

## Entrega
Exporta en MP4, comprueba audio y duración de 3 a 5 minutos. Si entregas un enlace, pruébalo en ventana privada. Repositorio: https://github.com/Nabh69/ayudanos-a-ayudar
GitHub almacena el código; no equivale a publicar el servidor Laravel. La demostración puede grabarse localmente.
