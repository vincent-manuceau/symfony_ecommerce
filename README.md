# symfony_ecommerce
Simple ecommerce platform built with Symfony - For learning/teaching purposes

## LAMP + Symfony + Symfony CLI Install
```
echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | sudo tee /etc/apt/sources.list.d/symfony-cli.list
sudo apt update
sudo apt install symfony-cli
git config --global user.email "vincent-manuceau"
```

## Creation Commands (second commit)
```
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
```
symfony console make:auth
```

## Adding user account space + login/logout logic + header links
```
symfony console make:controller
symfony console debug:router
```