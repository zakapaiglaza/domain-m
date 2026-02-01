## Функционал

- Авторизация и регистрация пользователей
- CRUD доменов (создание, редактирование, удаление)
- Настройка проверок:
    - Интервал проверки (минуты)
    - Таймаут запроса (секунды)
    - Метод запроса (HTTP GET / HEAD)
    - Активность домена (включен/выключен)
- Автоматические проверки по расписанию
- Логи проверок с информацией:
    - Дата и время
    - Статус (`UP` / `DOWN`)
    - HTTP код ответа
    - Время ответа
    - Ошибки (если есть)

## Установка

1. Клонировать репозиторий:
```bash
git clone https://github.com/zakapaiglaza/domain-m.git

cd domain-monitor

cp .env.example .env

docker compose exec app bash 

    composer install
    
    npm install
    
    npm run build

    php artisan key:generate

    php artisan storage:link
    
    php artisan migrate

    php artisan make:superadmin "login"

    php artisan config:clear

    php artisan cache:clear
    
    php artisan route:clear

    php artisan queue:restart
    
    php artisan queue:work

    tail -f storage/logs/laravel.log
