# RealFoodie
Tecnologías que se van a usar:

• Backend: Laravel como framework PHP para el desarrollo del servidor y la lógica de negocio.

• Frontend: HTML5, CSS3, JavaScript y Bootstrap5 para crear una interfaz responsiva y atractiva. 

• Base de datos: MySQL para el almacenamiento persistente de la información. 

• Autenticación: Sistema de autenticación integrado de Laravel (Laravel Breeze). 

• Almacenamiento de imágenes: Laravel Storage. 

• Búsqueda: Laravel Scout con Algolia para implementar búsquedas eficientes y rápidas.  -> He encontrado una forma más simple de poder implementar las búsquedas sin necesidad de usar esta tecnología

• Control de versiones: Git y GitHub para el seguimiento del desarrollo. 
• Cache: Redis para mejorar el rendimiento de la aplicación.  -> Muchos errores a la hora de sincronizar la BD NoSQL y MySQL

• Procesamiento de imágenes: Intervention Image para manipulación y optimización de imágenes -> Con el Storage que nos proporciona Laravel, no es necesario


Ideas en [este repositorio](https://github.com).

## Cosas por hacer 
- Subir a Visual Código Proyecto [Hecho]
- Imágenes vistas en la memoria [Faltan Fotos] -> Añadir también los nuevos cambios
- Entregar última parte Memoria y acabar código
- Foto Modelo Relacional [Hecho]
- Script Prueba BBDD [Hecho]

- Logo Página web -> No lo pilla la pestaña web
- Perfil [Hecho]
- Comentarios [Hecho]
- Favoritos -> Icono en la card para que puedas añadirlo a Fav y aparezca en tu perfil de usuario [Hecho]
- Colecciones -> Icono en la card para que puedas añadirlo a tus colecciones y un dropdown para que elijas a cual quieres añadirla [Hecho]
- Subir resolución Imágenes [Hecho]
- Cambiar imágenes [Hecho]
- Valoraciones con estrellas [Hecho]
- Seguidores
- Vistas Colecciones [Hecho]
- Borrar Datos de la BD y meter datos reales, con fotos y todo
- Configurar para que llegue al correo cuando se registran un mensaje de Bienvenida/ Notificaciones
- Recuperación de Contraseña 
- Header / ponerlo en todas las vistas
- Footer (En algunas vistas no va a estar presente)
- Botón de "Volver a Consultas" cambiar a un icono de volver a la página principal -> Quizás una Casa



## Solventar Errores
- Puedo entrar a la página principal sin necesidad de logear -> si pongo /home [Hecho]
- Si cierro la sesión y vuelvo hacia atrás sigue activa -> debería de llevarme al login [Hecho]
- Si uso las flechas hacia atrás me salta que se ha cerrado la sesión correctamente, pero si las vuelvo
a usar al no haber pulsado el botón de cerrar sesión, esta sigue activa [Hecho]
- Si el usuario esta logeado no puede volver al login o a la página de welcome si se mueve con las flechas en el navegador [Hecho]
- Cuando quieres agregar a Fav, sale que ha sido un éxito, pero en el perfil no aparece [Hecho]
- Cuando el usuario va a eliminar su cuenta no puede escribir, parece que la pagina se queda congelada


## Mejoras
- Que aparezca el nombre del usuario que las ha creado con la foto y puedes ir a su perfil (Recetas)
- Poner los Comentarios con otro diseño 
- Cuando vayas a ver las recetas de los usuarios más activos e ingredientes más usados, que puedas pulsarlas y te lleven a la receta (Quizás que se vea también la imagen)
- Filtros para el buscador
- Tener algo en el Header que muestre un punto rojo con la cantidad de notificaciones que tenga el usuario
- Cambiar la página principal un poco el diseño 

  
>>>>>>> 4d02988aaf92acf40dbde865e9410916b8f7e78a
