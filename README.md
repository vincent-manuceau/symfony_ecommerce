# symfony_ecommerce
Simple ecommerce platform built with Symfony - For learning/teaching purposes

## LAMP + Symfony + Symfony CLI Install on Debian Linux (as root)
```
apt install apache2 mariadb-server php
mysql_secure_installation 
apt install phpmyadmin
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | sudo tee /etc/apt/sources.list.d/symfony-cli.list
apt update
apt install symfony-cli
```

## Creation Commands (second commit)
HomeController
AccountController / UserRepository
RegisterController / RegisterType
```
git config --global user.email "vincent-manuceau"
symfony new laboutiquefrancaise --full
cd laboutiquefrancaise/
symfony server:start
symfony console make:controller
symfony console make:user
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
symfony console make:controller
symfony console doctrine:migrations:sync-metadata-storage
symfony console make:form
symfony console make:entity
symfony console make:migration
symfony console doctrine:migrations:migrate
```

## Adding user Login/Logout
SecurityController / LoginFormAuthenticator
```
symfony console make:auth
```

## Adding user account space + login/logout logic + header links
AccountController
```
symfony console make:controller
symfony console debug:router
```

## User Password Update
AccountPasswordController / ChangePasswordType
```
symfony console make:controller
symfony console make:form
```

