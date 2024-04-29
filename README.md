# SITE_NAME

SITE_NAME website with Symfony 6.0.8, PHP 8.1.6, Docker, Apache, MySQL and phpmyadmin.

## Main Configuration

### Configure docker containers

In docker >> docker-compose.yml find replace test by project name and change all the port for web, db & phpmyadmin.

### Install Dependencies :

```
docker-compose exec web bash
composer install
```

### Configure Xdebug

1. In PhpStorm go to: File | Settings | PHP | Debug, in Xdebug >> Debug port enter the port number (9010 for example).
2. Click on ADD Configurations (next phone symbole):

- In left of pop-up window click on + and choose PHP Remote Debug;
- Enter Name: Localhost (for example);
- Check: Filter debug connection by IDE key;
- In Server click in: ...;
- In left off the pop-up window click on +;
- Enter Localhost for Name (for example);
- Enter Localhost for Host,
- Enter the port number (check the web port in docker-compose);
- Select Use path mappings;
- in Project files >> got to your project root path >> next src enter: /var/www/html;
- Click: Apply.

3. Download the [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc) (Google Chrome extension) and in options >> IDE key copy "PHPSTORM".
4. Back in Run/Debug Configuration in IDE key(session id) enter the copied IDE key (PHPSTORM) then click Apply.
5. In Menu >> Run >> select : Break at first line in PHP scripts.
6. Click on the phone symbole until it change to green and in browser click on Xdebug helper until it change to green also
7. Go to your home page website and click f5 to refresh.
8. Finally, in Run >> uncheck : Break at first line in PHP scripts.

### Configuring the Database :

The database connection information is stored as an environment variable called DATABASE_URL.
For development, you can find and customize this inside app >> .env:

```
# to use mysql:
DATABASE_URL="mysql://badr:123456@db:3306/my_cabinet_db?serverVersion=8.0.27"
```

### Installing Doctrine :

```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

### Install the Profiler

`composer require --dev symfony/profiler-pack`

### Adding Rewrite Rules

The easiest way is to install the apache Symfony pack by executing the following command: `composer require symfony/apache-pack`

> Note: for more information check: [web server configuration](https://symfony.com/doc/current/setup/web_server_configuration.html).

## Main Tasks

To do ...

$ docker-compose down -v
$ sudo rm -rf db/
$ docker-compose up -d --force-recreate --build  
$ docker-compose exec web bash
$ symfony make:migration
$ symfony d:m:m

//installation d'une nouvelle application symfony

- symfony new GExams --full --version=6.0

modifier le fichier .env

//creation de la base de données selon les paramètres du fichier .env

- symfony console doctrine:database:create
- install certificat
- symfony server:ca:install
- start server
- symfony server:start -d

navigate to server
start https://127.0.0.1:8000

stop server

- symfony server:stop

creation de toutes les entités et des relation

- symfony console make:entity

creation des tables sur la base de données

- symfony console make:migration
- symfony console doctrine:migrations:migrate

create securité

- symfony console make:user >>> User yes email yes
- symfony console make:entity >>> User username string 50 no
- install authenticator
- symfony console make:auth >>> 1 AppAuthenticator SecurityController yes
- symfony console make:registration >>> yes no yes
- composer require symfonycasts/reset-password-bundle
- symfony console make:reset-password >>> \n email@fac.ma "gestion exams"

remplacer le text dans le fichier \\src\\Security\\AppAuthenticator.php
//return new RedirectResponse($this->urlGenerator->generate('some_route'))
		return new RedirectResponse($this->urlGenerator->generate('dashboard'))

remplacer le text dans le fichier
\config\packages\\security.yaml # - { path: ^/admin, roles: ROLE_ADMIN } - { path: ^/admin, roles: ROLE_USER }

- symfony console make:migration
- symfony console doctrine:migrations:migrate

- installer les fixtures
- composer require zenstruck/foundry --dev

faire la même chose pour toutes les entité et pour User aussi

- symfony console make:factory 0
- composer require orm-fixtures --dev

ajouter use dans le fichier appFixtures.php pour toutes les entités et User aussi

\src\DataFixtures\AppFixtures.php --> use App\Factory\EtudiantFactory;

ajouter pour chaque entité une ligne de remplissage dans le procedure load
FiliereFactory::createMany(10);

Modifier les fixtures dans les fichiers factory de chaque entité remplacer text par le type correspondant
exemple:
return [
// TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
'nom' => self::faker()->lastname(),
'prenom' => self::faker()->firstname(),
'filiere' => FiliereFactory::randomOrCreate(),
'cin' => self::faker()->realText(10),
];

Modifier le contenu de la procedure getDefaults de UserFactory avec le code suivant

return [
'email' => 'admin@fac.ma',
'roles' => ['ROLE_ADMIN'],
'password' => '$2y$13$w7usfxJhm1MP8qjT8TDNzOq.UuYWFuZszfwqX/agMwG8JeqWgacZ.',
'username' => 'Admin',
];

charger les fixtures

- symfony console doctrine:fixtures:load

installation de la dash board

- composer require admin
- symfony console make:admin:dashboard \n \n

ajouter les classes suivantes aux fichier DashboardController
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Etudiant;
use App\Entity\Filiere;
use App\Entity\User;

ajouter les lien à configureMenuItems du DashboardController

        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Filiere', 'fas fa-list', Filiere::class);
        yield MenuItem::linkToCrud('Etudiant', 'fas fa-list', Etudiant::class);

ajouter ces deux procedures au DashboardController

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->setGravatarEmail($user->getEmail())
         //   ->setAvatarUrl('https://www.clipartmax.com/png/full/405-4050774_avatar-icon-flat-icon-shop-download-free-icons-for-avatar-icon-flat.png')
            ->displayUserAvatar(true);
    }



    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/css/admin.css');
    }

ajouter le controller admin a toutes les entités

- symfony console make:admin:crud

installer node js (logiciel a chercher sur internet)

- composer require symfony/webpack-encore-bundle
- yarn install
- yarn add jquery
- yarn add sass-loader sass --dev
- yarn add postcss-loader autoprefixer --dev
- npm install --save-dev @fortawesome/fontawesome-free
- yarn add file-loader@^6.0.0 --dev
- yarn add bootstrap

ajouter ces lignes a app.js
import $ from 'jquery';

import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';

renommer le fichier app.css en app.scss
modifier la ligne import './styles/app.css'; dans app.js en import './styles/app.scss';
changer le contenu de app.scss par

@import 'custom';
@import '~bootstrap/scss/bootstrap';

creer le fichier custom.scss dans assets/styles

copier le dossier css, js et images dans assets

ajouter les procedure à webpack.config
.copyFiles({
from: './assets/images',

             // optional target path, relative to the output dir
             to: 'images/[path][name].[ext]',

             // if versioning is enabled, add the file hash too
             //to: 'images/[path][name].[hash:8].[ext]',

             // only copy files matching this pattern
             //pattern: /\.(png|jpg|jpeg)$/
         })

.copyFiles({
from: './assets/css',
to: 'css/[path][name].[ext]',
})

activer dans le fichier webpack.config
.enableSassLoader()
.autoProvidejQuery()

.addEntry('langues', './assets/js/langues.js')

copier les dossier eventsubsriber
et le fichier ChangeLangueController.php

remplacer les templates surtout change langue
ajouter les fichiers messages.ar.yaml, fr, en et es

- symfony console cache:clear
- yarn run build
