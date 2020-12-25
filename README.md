
# API para alquiler de vehículos

Es una API desarrollada con PHP con el framework Laravel que utiliza una base de datos MySQL. Permite ver los carros disponibles para alquiler, registrar usuarios, iniciar sesión, cerrar sesión, crear órdenes de alquiler, ver las ordenes existentes en el sistema y ver el perfil del usuario logeado junto al historial de órdenes de alquiler asociadas.

## Requisitos para probar en local

- PHP (7.4.11 en adelante)
- Composer (para el manejo de dependencias)
- XAMPP con el paquete de MySQL y servidor apache (configuración por defecto)
- Postman (u otra aplicación para hacer las peticiones de prueba)

Nota: el funcionamiento de la aplicación fue probado en el sistema operativo de Windows 10. Puede haber problemas de compatibilidad en otros SO.

## Pasos para probar en local

1. Clonar el repositorio.
2. Para instalar las dependencias, dentro del proyecto ejecutar:
```
composer install
```
3. Arrancar el servidor apache junto al módulo de MySQL.
4. Desde phpmyadmin crear una base de datos con el nombre 'laravel'.
5. Para para crear las tablas de la base de datos, ejecutar dentro del proyecto:
```
php artisan migrate
```
6. Para para rellenar las tablas de la base de datos con informacion de prueba, ejecutar dentro del proyecto:
```
php artisan db:seed
```
7. Finalmente, arrancar el servidor ejecutando dentro del proyecto:
```
php artisan serve
```
Nota: puerto por defecto: 8000
## Endpoints

- GET http://localhost:8000/api/cars
  - Devuelve todos los vehículos disponibles mostrando el modelo, una descripción, y la tarifa diaria.

- GET http://localhost:8000/api/orders
  - Devuelve todas las ordenes de alquiler existentes, sin mostrar el id del usuario asociado a dicha orden.

- POST http://localhost:8000/api/register
  - Permite registrar un usuario nuevo. Enviar los datos a través de un JSON que especifique los campos name, email y password. El email debe ser válido y la contraseña entre 12 y 25 caracteres. Ejemplo:
```
{
    "name": "Juan",
    "email": "juan@test.com",
    "password": "123456789asdasd"
}
```

- POST http://localhost:8000/api/login
  - Permite logear a un usuario. Si las credenciales son correctas devolverá un token para realizar las peticiones protegidas. El token deberá colocarse en la cabecera de la petición, en el parametro Authorization (del tipo Bearer Token). Ejemplo de petición:
```
{
    "email": "juan@test.com",
    "password": "123456789asdasd"
}
```
  - Ejemplo de respuesta:
```
{
    "user": {
        "id": 4,
        "name": "Juan",
        "email": "juan@test.com"
    },
    "token": "1|H2ADgIecQtJ2qz4WcVWMye5UUu3LtNZQxnaXAL1V"
}
```

- POST http://localhost:8000/api/orders
  - Permite crear una order de alquiler solo a usuarios logeados. Enviar los datos a través de un JSON que especifique los campos user_id, car_id, starting_date y ending_date. El formato de las fechas debe ser de tipo YYYY-mm-dd y no deben solapar con ordenes ya existentes para ese vehículo. Ejemplo:
```
{
    "user_id": 4,
    "car_id": 2,
    "starting_date": "2021-02-01",
    "ending_date": "2022-02-12"
}
```
- GET http://localhost:8000/api/profile/{user_id}
  - Permite ver el perfil del usuario logeado y el historial de ordenes de alquiler asociado. Ejemplo de respuesta:
```
{
    "id": 4,
    "name": "Juan",
    "email": "juan@test.com",
    "rent_orders": [
        {
            "id": 2,
            "starting_date": "2021-02-01",
            "ending_date": "2021-02-12",
            "car_id": 2
        }
    ]
}
```

- DELETE http://localhost:8000/api/orders/{order_id}
  - Permite eliminar una order de alquiler solo al usuario logeado que realizó la orden. Recibirá una respuesta exitosa si se eliminó correctamente.
  
- GET http://localhost:8000/api/logout/{user_id}
  - Cierra la sesión del usuario logeado.
  
