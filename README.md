# API онлайн библиотека

### Описание

Онлайн библиотека, которая предоставляет доступ к списку книг, позволяет пользователям добавлять книги в свой список избранных, поиска и управления книгами.

Основные функции онлайн библиотеки включают:

 1. Регистрация и аутентификация: Пользователи могут создать аккаунт, указав свою почту и пароль, и затем использовать эти учетные данные для входа в систему.

 2. Просмотр списка всех доступных книг: Все пользователи могут просматривать список всех доступных книг, а также получать информацию о каждой книге, такую как заголовок и описание.

 3. Добавление и удаление книг: Администраторы системы имеют возможность добавлять новые книги в библиотеку, указывая заголовок и описание каждой книги. Также администраторы могут удалять книги из библиотеки при необходимости.

 4. Управление списком избранных книг: Зарегистрированные пользователи могут добавлять книги в свой список избранных и удалять их из списка. Каждый пользователь имеет доступ только к своему списку избранных книг.

 5. Выгрузка списка книг в формате CSV: Администраторы могут выгружать список всех книг в формате CSV для удобного использования и анализа данных.

## Установка

Чтобы установить и настроить наш проект онлайн библиотеки, следуйте инструкциям ниже:

1. Убедитесь что у вас утановлен PHP и Composer.
2. Скопируйте данный репозиторий:

   ```
   git clone https://github.com/your-username/your-repository.git
   ```
4. Установка зависимостей проекта:

   ```
   composer install
   ```
5. Создайте файл **'.env'** на основе файла **'.env.example'** и настройте соответствующие параметры окружения, такие как настройки базы данных.
6. Выполните миграции баз данных:

   ```
   php artisan migrate
   ```
   > И по вашему усмотрению. В проекте доступны подготовленые данные для тестирования, доступна по команде:

   ```
   php artisan db:seed
   ```
8. Запуск локального сервера (доступ к серверу вы можете указать в файле **'.env'** по умолчанию: [http://localhost:8000](http://localhost:8000))

   ```
   php artisan serve
   ```
## Использование

Проект предлагает следующие функции, которые вы можете использовать:

 1. **Регистрация и вход в систему, а так же команда для смены роли пользователю**:
    - Для регистрации нового пользователя отправьте POST-запрос на /api/register с параметрами email и password. Пример:

      ```
      curl -X POST -H "Content-Type: application/json" -d '{"email":"user@example.com","password":"password123"}' http://localhost:8000/register
      ```
    - Для входа в систему отправьте POST-запрос на /api/login с параметрами email и password. Пример:

      ```
      curl -X POST -H "Content-Type: application/json" -d '{"email":"user@example.com","password":"password123"}' http://localhost:8000/login
      ```
    - Для выдачи пользователю роль _admin_ или _client_(по умолчанию при создании пользователь имеет роль: _client_), нужно ввести команду, где **user_id** - айди пользователя, а так же **role** - роль пользователя (может быть: _admin_ или _client_):

      ```
      php artisan change-role {user_id} {role}
      ```


 2. **Просмотр списка книг**:
    - Чтобы получить список всех доступных книг, отправьте GET-запрос на /api/books. Пример:

      ```
      curl -X GET http://localhost:8000/books
      ```
    - Чтобы получить информацию по отдельной книге, отправьте GET-запрос на /api/books. Пример:

      ```
      curl -X GET -H "Content-Type: application/json" -d '{"id": 4' http://localhost:8000/books
      ```
 
 3. **Добавление и удаление книг**:
    - Для добавления новой книги в библиотеку отправьте POST-запрос на /api/books с параметрами title и description, author, genre. Для этой операции **требуется аутентификация с ролью администратора**. Пример:

      ```
      curl -X POST -H "Content-Type: application/json" -d '{"email": "use@example.com", "password": "password123", "title":"New Book","description":"This is a new book.", "author": "Author", "genre": "Genre"}' http://localhost:8000/books
      ```
    - Для удаления книги из библиотеки отправьте DELETE-запрос на /api/books/{book_id}, где {book_id} - идентификатор книги. Для этой операции также **требуется аутентификация с ролью администратора**. Пример:

      ```
      curl -X DELETE -H "Content-Type: application/json" -d '{"email": "use@example.com", "password": "password123", "id": 5}' http://localhost:8000/books
      ```

 4. **Управление списком избранных книг**:
    - Для добавления книги в список избранных отправьте POST-запрос на /users/favorite с параметрами book_id. Для этой операции требуется **аутентификация**. Пример:

      ```
      curl -X POST -H "Content-Type: application/json" -d '{"email": "use@example.com", "password": "password123", "id": 5}' http://localhost:8000/users/favorite
      ```
    - Для удаления книги из списка избранных отправьте DELETE-запрос на /users/favorite. Для этой операции также требуется **аутентификация**. Пример:

      ```
      curl -X DELETE -H "Content-Type: application/json" -d '{"email": "use@example.com", "password": "password123", "id": 5}' http://localhost:8000/books
      ```

 5. **Выгрузка списка книг в формате CSV**:
    - Чтобы выгрузить список всех книг в формате CSV, отправьте GET-запрос на /books/export. Для этой операции **требуется аутентификация с ролью администратора**. Пример:

      ```
      curl -X GET -H "Content-Type: application/json" -d '{"email": "use@example.com", "password": "password123"}' http://localhost:8000/books/export
      ```


# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

> **Note:** In the years since releasing Lumen, PHP has made a variety of wonderful performance improvements. For this reason, along with the availability of [Laravel Octane](https://laravel.com/docs/octane), we no longer recommend that you begin new projects with Lumen. Instead, we recommend always beginning new projects with [Laravel](https://laravel.com).

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
