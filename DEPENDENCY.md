Tout ce qu'il faut téléchargé pour bien commencer
===

Symfony 4
--
    composer create-project symfony/skeleton my-project

Le server
--
    cd my-project
    composer require symfony/web-server-bundle --dev
    php bin/console server:run (Pour lancer le server)
    
    php -S 127.0.0.1:9000 -t public (Si on veut choisir un port spécifique)
    
Le profiler: pour avoir la barre dans le footer
--
    composer require --dev symfony/profiler-pack
    
L'annotation : pour les routes
--
    composer require annotations

Le validator: pour faire les vérifications dans les entités
--
    composer require symfony/validator
    
TWIG
--
    composer require symfony/twig-bundle

Base de données
--
    composer require symfony/orm-pack
    composer require symfony/maker-bundle --dev
    
Encore: pour le js et le css
--
    composer require webpack-encore
    Ne pas oublier d'installer yarn pour la compilation : npm install yarn --global
    Ensuite lancer un : yarn install
    
    Au cas ou: yarn add webpack-notifier --dev (J'ai pas compris ce que ça fait, c'est la console qui m'a recommandé ça)

Security: pour la gestion des utilisateurs
--
    composer require symfony/security-bundle

Formulaire: `contient la commande pour faire le CRUD`
--
    composer require form
 