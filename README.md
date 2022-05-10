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



### Creating project (Home)
HomeController
```
git config --global user.email "vincent-manuceau"
symfony new laboutiquecreole --full
cd laboutiquecreole/
symfony server:start
```
### Account + User Entity + Doctrine migration (creating BDD schema...)
AccountController / UserRepository
```
symfony console make:controller
symfony console make:user
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
```

### Register new user + Doctrine migration (updating BDD schema)
RegisterController / RegisterType
```
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

## Quick template polishing with css
base.html.twig

## Creating Admin interface with EasyAdmin
DashboardController / UserCrudController
```
composer require easycorp/easyadmin-bundle
symphony console make:admin:dashboard
symfony console make:admin:crud
```

## Categories Entity + Admin Mapping
CategoryCrudController
```
symfony console make:entity
symfony console make:migration
symfony console doctrine:migration:migrate
symfony console make:admin:crud
```

## Product Entity + Admin Mapping
```
symfony console make:entity
symfony console make:migration
symfony console doctrine:migrations:migrate
symfony console make:admin:crud
```
Images are uploaded in public/uploads/

## Create products view + Single product view
ProductController
```
symfony console make:controller
```

## Create product filter in products view
Search (class), SearchType

## Add to Cart with SessionInterface
Cart (class), CartController
```
symfony console make:controller
```

## Increase/Decrease/Delete product from cart


## User Addresses Entity
```
AddressRepository / AccountAddressController / AddressType
symfony console make:entity
symfony console make:migration
symfony console doctrine:migrations:migrate
symfony console make:controller
symfony console make:form
``` 	