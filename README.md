<!--Установка-->

1. Клонирование репозитория 

```git clone https://github.com/aigor1999/cinema-portal```

2. Переход в директорию cinema-portal

```cd cinema-portal```

3. Инициализация yii2

```php init```

4. Установка зависимостей

```composer install```

5. Создание базы данных для портала и настройка параметров подключения в файле common/config/main-local.php

6. Запуск миграции для инициализации БД портала

```php yii migrate```
  