## Descargar dependencias correspondientes
Ingresar a las rutas de cada carpeta y utilizar el siguiente comando
```
npm i 
```

## Crear las imagenes correspondientes para cada servicio
```
docker build -t imagen ./ruta
```

## Levantar los servicios 
```
docker stack deploy -c services.yml nombre-servicios
```

## Ingresar al sitio web
```cls
http://localhost:3002
``` 