PHP test examples
-----------------

### Install:

```
cd ./docker

cp example.env .env

docker-compose up --build -d
```

## Examples:
<br>



### Пример тестирования класса UserStore и Validator (Matt Zandstra)

---

Реализация тестов для классов UserStore (массив пользователей) и Validator (использование mock).

[user_store](https://github.com/eatae/php-test-examples/tree/master/user_store)

run tests:
```
docker exec -it phptests-php-cli vendor/bin/phpunit user_store/tests
```
<br>




### Делаем код тестируемым (Vladimir Khorikov)

---
Реализуем запись в файл всех посетителей приложения: <br>
- имя пользователя, время посещения


#### 1. Первый вариант является менее удачным.<br>
В таком виде метод AuditManager::addRecord() тестировать сложно, потому что код логически не разделен и тесно связан с файловой системой:

[audit/v1](https://github.com/eatae/php-test-examples/tree/master/audit/v1)

run tests:
```
docker exec -it phptests-php-cli vendor/bin/phpunit audit/v1/tests
```
<br>


#### 2. Разделяем логику.<br>

Типичное решение проблемы сильной связности тестов — создание мока для файловой системы. <br>
Все операции с файлами выделяются в отдельный тип (IFileSystem), который внедряется в AuditManager через конструктор. 
Затем в тесте мы используем мок типа (IFileSystem) и перехватываем методы обращения записи и чтения файлов.
То есть нам не нужно использовать реальную работу с файловой системой - используем Mock с настройкой его методов.

[audit/v2](https://github.com/eatae/php-test-examples/tree/master/audit/v2)

run tests:
```
docker exec -it phptests-php-cli vendor/bin/phpunit audit/v2/tests
```
<br>


#### 3. Переходим на функциональную архитектуру.<br>






Изменяем логику кода приводя к функциональной(гексагональной) архитектуре и тестируем выходные данные:
*  переход от внепроцессной зависимости к использованию мока;
*  переход от мока к функциональной архитектуре;





