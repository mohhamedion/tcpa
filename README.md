- Запустить с помощью докера

```php
cd docker
sudo docker-compose up
```

- Установить зависимости с помощью контейнера
```phpregexp
sudo docker exec -it tcpa-app composer install
```

- Миграция 
```phpregexp
sudo docker exec -it tcpa-app php artisan migrate
```

- Актуализирование существующих ролей
```
sudo docker exec -it tcpa-app php artisan app:init-app
```

- Создать супер-админа
```
sudo docker exec -it tcpa-app php artisan app:create-admin {name} {login} {password}
```

Например
```phpregexp
sudo docker exec -it tcpa-app php artisan app:create-admin admin admin admin
```
