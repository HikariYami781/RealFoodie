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
- Seguidores ->  [Hecho]
- Vistas Colecciones [Hecho]
-Foto por defecto usuarios [Hecho]
- Borrar Datos de la BD y meter datos reales, con fotos y todo 
- Header / ponerlo en la mayoría de vistas[Hecho]
- Footer (En algunas vistas no va a estar presente) [Hecho]



## Solventar Errores
- Puedo entrar a la página principal sin necesidad de logear -> si pongo /home [Hecho]
- Si cierro la sesión y vuelvo hacia atrás sigue activa -> debería de llevarme al login [Hecho]
- Si uso las flechas hacia atrás me salta que se ha cerrado la sesión correctamente, pero si las vuelvo
a usar al no haber pulsado el botón de cerrar sesión, esta sigue activa [Hecho]
- Si el usuario esta logeado no puede volver al login o a la página de welcome si se mueve con las flechas en el navegador [Hecho]
- Cuando quieres agregar a Fav, sale que ha sido un éxito, pero en el perfil no aparece [Hecho]
- Cuando el usuario va a eliminar su cuenta no puede escribir, parece que la pagina se queda congelada [Hecho]
- El Botón Ver Mis colecciones que esté debajo de "Editar Perfil" y no duplicado también en la pestaña de las colecciones [Hecho]


## Mejoras [Puesto en Memoria]
- Configurar para que llegue al correo cuando se registran un mensaje de Bienvenida
- Recuperación de Contraseña
- Poner los Comentarios con otro diseño 
- Filtros para el buscador
- Tener algo en el Header que muestre un punto rojo con la cantidad de notificaciones que tenga el usuario
- Cambiar la página principal un poco el diseño 
- Aumentar Avatares por defecto
- Buscar usuarios y usuarios recomendados
- Página adicional donde puedas ver las publicaciones de los usuarios que sigues

  
>>>>>>> 4d02988aaf92acf40dbde865e9410916b8f7e78a
