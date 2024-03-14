The task was implemented using laravel php framework 
to set it up you will need to have xampp (recomended) or any other software capable of handling apache and mysql
if xampp is used ensure the project location is inside the htdocs folder of xampp,
cd into the project 
once set up create a database named banking_system and ensure your database runs on localhost port 3306
ensure u rename the .env example to .env then run the following commands in order
composer install 
php artisan key:generate
php artisan migrate php artisan serve
Then open another terminal in the same directory and run 
npm install , once through then run 
npm run dev,
