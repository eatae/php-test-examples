PHP test examples
-----------------

### Install:

```
cd ./docker

cp example.env .env

docker-compose up --build -d
```


### Examples:

#### Мэт Занстра (UserStore and Validator)

Пример модульных тестов для классов UserStore (массив пользователей) и Validator (пример mock).

  * [user_store](https://github.com/eatae/masteringGo/blob/master/ch01/logFiles.go)

<b>run:
```
docker exec -it phptests-php-cli vendor/bin/phpunit user_store/tests
```