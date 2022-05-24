# Superio-Job-Board-Laravel
👨‍💻 Superio Job Board Laravel

Run laravel project locally
##Windows users:

Download wamp: http://www.wampserver.com/en/
Download and extract cmder mini: https://github.com/cmderdev/cmder/releases/download/v1.1.4.1/cmder_mini.zip
Update windows environment variable path to point to your php install folder (inside wamp installation dir) (here is how you can do this http://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash)
cmder will be refered as console

##Mac Os, Ubuntu and windows users continue here:

Create a database locally named homestead utf8_general_ci
Download composer https://getcomposer.org/download/

env.example => .env
composer install 
or
 php composer.phar install

php artisan key:generate
php artisan migrate
php artisan db:seed
to run seeders, if any.
php artisan serve

#####You can now access your project at localhost:8000 :)

If for some reason your project stop working do these:
composer install
php artisan migrate