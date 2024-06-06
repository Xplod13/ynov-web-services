# MUCKENSTURM Nicolas - GRANIER-DEFRANCE Victor

# Créer le network

```
docker network create app_network
```

# Créer les volumes

```
docker volume create db
docker volume create pgadmin
```

# Builder le projet
```
docker compose build
```

# Lancer le projet
```
docker compose up
```

# Charger les migrations

```
docker container exec -it auth-api php artisan migrate && 
docker container exec -it movie-api php artisan migrate && 
docker container exec -it reservation-api php artisan migrate
```

# Charger les fixtures

## Exécuter cette commande
```
docker container exec -it auth-api php artisan db:seed && 
docker container exec -it movie-api php artisan db:seed && 
docker container exec -it reservation-api php artisan db:seed
```

# Si vous avez des erreurs faites
[Setup de l'api Movie API](movie-api/README.md)<br>
[Setup de l'api Auth API](auth-api/README.md)<br>
[Setup de l'api Réservation API](reservation-api/README.md)

