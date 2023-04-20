# Интеграция AmoCRM

Проект создан в рамках тестового задания по созданию простой интеграции AmoCRM.

Функцонал проекта заключается в авторизации аккаунта пользователя через oauth2 и добавления сделки, параметры которой заполняются из формы, доступной после авторизации.

Для реализации выбран паттерн MVC.

## Установка
```
composer install
```

После установки интеграция требует конфигурации в файле .env в корне проекта.
Поля, необходимые для заполнения в файле .env:
```
CLIENT_ID = ""
CLIENT_SECRET = ""
REDIRECT_URL = ""
```