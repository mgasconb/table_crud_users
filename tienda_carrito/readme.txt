Tienda con carrito de la compra.


Premisas.

Un carrito es como un pedido.

Un usuario anónimo entra a en la tienda y preprara su carrito.
Si el usuario anónimo abandona sin comprar su carrito debería quedar grabado en un fichero de session que se identificará con la cookie de sessión que quedó grabado en el navegador. Las cookies de sesión deben permanecer en el tiempo lo que se prevea (15 días, 1 mes, ...)
Si vuelve a la tienda con el mismo navegador, antes de que caduque la cookie de sesión verá el carrito que dejó.
Si vuelve con otro navegador no verá el carrito que dejó.

Para comprar el usuario tiene que conectarse, o crear una cuenta y conectarse después (atención no hay que cambiar el contenido de la cookie de sesión al cambiar de usuario).
Si el usuario anónimo se conecta, el carrito se pasa desde la SESSION hasta la base de datos.


Un usuario logueado entra en la tienda y prepara su carrito. El carrito se guarda en la base de datos.
Si abandona sin comprar quedará grabado en la base de datos como un pedido incompleto o inacabado.