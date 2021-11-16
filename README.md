### php tests examples

#### Install

```
cd ./docker

docker-compose up --build -d

docker exec -it phptests-php-cli composer require --dev phpunit/phpunit

```

run tests
```
docker exec -it phptests-php-cli vendor/bin/phpunit user_store/tests
```


user_store
    Мэт Занстра