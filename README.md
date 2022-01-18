PHP test examples
-----------------

### Install:

```
cd ./docker

cp example.env .env

docker-compose up --build -d
```


### Examples:

#### UserStore and Validator (Matt Zandstra)

Пример модульных тестов для классов UserStore (массив пользователей) и Validator (пример mock).

  * [user_store](https://github.com/eatae/masteringGo/blob/master/ch01/logFiles.go)

<b>run tests:</b>
```
docker exec -it phptests-php-cli vendor/bin/phpunit user_store/tests
```
<br>

#### Переход на функциональную архитектуру (Vladimir Khorikov)

Изменяем логику кода приводя к функциональной(гексагональной) архитектуре и тестируем выходные данные:
*  переход от внепроцессной зависимости к использованию мока;
*  переход от мока к функциональной архитектуре;





