## To Start test

run 
```shell
docker run --name yellowmedia -p 5432:5432 -e POSTGRES_USER=user -e POSTGRES_PASSWORD=secret -e POSTGRES_DB=ym_db -d postgres:13.3
```

```shell
 php artisan migrate
```

```shell
 php artisan db:seed
```

```shell
php -S localhost:8000 -t public
```

## Sign in for get a token
##### password for user is a first_name field
