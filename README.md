Разворачивание приложения:
- composer update --optimize-autoloader
- php artisan key:generate
- php artisan config:cache
- php artisan migrate 
- php artisan db:seed --class=CategoriesTableSeeder
- php artisan l5-swagger:generate

Swagger-ui доступен по роуту "/api/documentation"

Для хранения категорий выбран паттерн nested sets


