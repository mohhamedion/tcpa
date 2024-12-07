# Запуск с помощью Docker

## PHP

1. Перейти в директорию `docker`:
   ```bash
   cd docker
   ```
2. Запустить контейнеры:
   ```bash
   sudo docker-compose up
   ```
## Создать .env
```bash
cp  .env.example .env
```

```bash
sudo docker exec -it tcpa-app php artisan key:generate
```

## Установка зависимостей через контейнер
```bash
sudo docker exec -it tcpa-app composer install
```

## Выполнение миграций
```bash
sudo docker exec -it tcpa-app php artisan migrate
```

## Актуализация существующих ролей
```bash
sudo docker exec -it tcpa-app php artisan app:init-app
```

## Создание супер-администратора
```bash
sudo docker exec -it tcpa-app php artisan app:create-admin {name} {login} {password}
```

### Пример:
```bash
sudo docker exec -it tcpa-app php artisan app:create-admin admin admin admin
```

---

# СКРИНШОТЫ С ОПИСАНИЕМ

## Панель администратора
- **Страница авторизации**: [http://localhost:8252/login](http://localhost:8252/login)

Авторизоваться могут как администраторы, так и агенты.  
![img_1.png](img_1.png)

Чтобы создать компании и агентов, необходимо войти в систему под учетной записью администратора.  
Создать администратора можно через командную строку (описано выше).

- **Страница компаний**: [http://localhost:8252/companies](http://localhost:8252/companies)  
  На этой странице можно создавать компании, а также агентов, которые будут принадлежать этим компаниям.  
  ![img_2.png](img_2.png)

- **Страница агентов**, привязанных к компаниям:  
  ![img_3.png](img_3.png)

---

## Панель агента
Перед началом работы необходимо указать данные аккаунта Twilio:
- `SID`
- `Token`
- `Phone Number`

После этого станет доступно создание клиентов.  

![img_4.png](img_4.png)

- **Страница настройки Twilio**  
  На этой странице отображается уникальная ссылка вебхука для данной компании. Эту ссылку необходимо добавить в настройки Twilio.  
  ![img_5.png](img_5.png)

После сохранения настроек появится возможность создания клиентов.  

![img_6.png](img_6.png)

---

- **Страница со всеми клиентами**  
  ![img_7.png](img_7.png)

- **Страница создания клиентов**  
  ![img_8.png](img_8.png)

После создания клиента станет доступна кнопка для отправки кода подтверждения.  

![img_9.png](img_9.png)

- **Ввод кода подтверждения**  
  ![img_10.png](img_10.png)

После успешного подтверждения система отправляет запрос на получение согласия.  

![img_11.png](img_11.png)

На этой же форме доступен режим тестирования ответа без использования вебхука.  

![img_12.png](img_12.png)


- Страница для настройки шаблонов сообщения  

![img_14.png](img_14.png)
