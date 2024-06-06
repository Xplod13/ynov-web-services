# Setup de l'api de reservation

### IP

http://localhost:7000/api

### Se connecter au container

```
docker container exec -it reservation-api /bin/bash
```


### Télécharger les packages

```
composer install
```

### Donner des droits au dossier storage

```
chmod 777 -R storage
```

### Migrer la bdd

```
php artisan migrate
```

### Loader les fixtures

```
php artisan db:seed
```
