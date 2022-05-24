# Superio-Job-Board-Laravel
👨‍💻 Superio Job Board Laravel <br>

Run laravel project locally <br>
##Windows users: <br>

Download wamp: http://www.wampserver.com/en/ <br>
Download and extract cmder mini: https://github.com/cmderdev/cmder/releases/download/v1.1.4.1/cmder_mini.zip <br>
Update windows environment variable path to point to your php install folder (inside wamp installation dir) (here is how you can do this http://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash) <br>
cmder will be refered as console <br>

##Mac Os, Ubuntu and windows users continue here: <br>

Create a database locally named homestead utf8_general_ci <br>
Download composer https://getcomposer.org/download/ <br>

env.example => .env <br>
composer install  <br>
or <br>
 php composer.phar install <br>

php artisan key:generate <br>
php artisan migrate <br>
php artisan db:seed <br>
to run seeders, if any. <br>
php artisan serve <br>

#####You can now access your project at localhost:8000 :) <br>

If for some reason your project stop working do these: <br>
composer install <br>
php artisan migrate <br>
