# restapi_auth

IF YOU ARE USING GIT PROJECT then THERE IS NO Vendor folder , SO TO GET Vendor Folder YOU NEED COMPOSER , USE following command
docker run --rm --interactive --tty -v $(pwd):/app composer update


rename .env.example to .env

php artisan migrate --path=database/migrations/2023_05_27_062030
_create_roles_table.php 

Then run php artisan migrate

php artisan db:seed

Product management with product image upload and image resize for small and medium image(only created thumbnails not stored into database)
Multiple file upload with image resize
Its included User authentication with authorization
Implemented register/login/getUser/logout/update profile functionalities
Implemented roles and permission , applied on product add/delete and order status action
