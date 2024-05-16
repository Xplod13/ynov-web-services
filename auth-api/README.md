# Setup de l'api auth

### Se connecter au container

```
docker container exec -it auth-api /bin/bash
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

## User
* login
* password
* roles
* status

# Routes disponibles

* POST            api/account 
* GET|HEAD        api/account/{account}
* PUT|PATCH       api/account/{account}
* POST            api/login
* GET|HEAD        api/refresh-token/{refreshToken}/token
* GET|HEAD        api/validate/{accessToken}
