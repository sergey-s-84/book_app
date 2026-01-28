Установка и запуск проекта

1. Клонируем репозиторий
   
   git clone https://github.com/sergey-s-84/book_app.git

2. Переходим в папку проекта
   
   cd book_app

3. Поднимаем проект через Docker
   
   docker-compose up -d --build


4. Устанавливаем зависимости Yii2
   
   docker-compose exec php composer install

5. Переименовываем файл настроек БД

   www/config/db.php.example --> www/config/db.php


6. Применяем миграции
    
   docker-compose exec php php yii migrate



Проект будет доступен по адресу: http://localhost:8080/
