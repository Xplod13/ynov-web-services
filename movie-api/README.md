# Setup de l'api movie


### IP

http://localhost:8000/api

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

# Base de données

## Movie
* name
* description
* released_at
* review

## Category
* name

# Routes disponibles
* GET|HEAD        api/categories
* POST            api/categories
* GET|HEAD        api/categories/{category}
* PUT|PATCH       api/categories/{category}
* DELETE          api/categories/{category}
* GET|HEAD        api/categories/{category}/movies
* GET|HEAD        api/movies
* POST            api/movies
* GET|HEAD        api/movies/{movie}
* PUT|PATCH       api/movies/{movie}
* DELETE          api/movies/{movie}
* GET|HEAD        api/movies/{movie}/categories
