# Setupe de l'api movie

### Se connecter au container

```
docker container exec -it movie-api /bin/bash
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
