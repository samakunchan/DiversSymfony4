Commande pour Symfony 4
==

Voir la liste des commandes
---
    php bin/console
Run le server
--
    php bin/console server:run
    
    php -S 127.0.0.1:9000 -t public
    
    Pour passer en mode prod, il faut ouvrir le fichier .env et remplacer APP_ENV=dev par APP_ENV=prod
    
[Pour configurer un nouvelle environnement](https://symfony.com/doc/current/configuration/environments.html)
    
Créer la base de donnée
--
Remplacer les valeurs de la ligne ci-dessous dans le fichier `.env`

        DATABASE_URL=mysql://db_user:_db_password@127.0.0.1:3306/db_name
        Ex: avec wamp
        db_user = root
        db_password = Ne rien mettre
        db_name = le nom de la base de donnée
Après avoir configurer le fichier `.env`

    php bin/console doctrine:database:create
    
    Effacer la BDD:
        php bin/console doctrine:database:drop --force
    
Controller
--
    php bin/console make:controller
    Ensuite, il faut choisir le nom du controller Ex: HomeController

Entity
-
    php bin/console make:entity
    Ensuite, il faut choisir le nom de l'entité
    
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    
    Pour faire les vérifications, utilisez le:
        use Symfony\Component\Validator\Constraints as Assert;
    
    Créer des setter et getter:
        php bin/console make:entity --regenerate
    
Les Routes
--
    php bin/console debug:router
    
CRUD
-
    php bin/console make:crud Product
  
Les formulaires
--
    php bin/console make:form RegistrationType    "RegistrationType" est le nom qu'on doit choisir pour le formulaire
    
Cache
--
    php bin/console cache:clear
      
Error 404
--
    public function index()
    {
        // retrieve the object from database
        $product = ...;
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
    
            // the above is just a shortcut for:
            // throw new NotFoundHttpException('The product does not exist');
        }
    
        return $this->render(...);
    }

Session
--
        // stores an attribute for reuse during a later user request
        $session->set('foo', 'bar');
    
        // gets the attribute set by another controller in another request
        $foobar = $session->get('foobar');
    
        // uses a default value if the attribute doesn't exist
        $filters = $session->get('filters', array());
   
Build JS et CSS : Encore
--
        yarn encore dev
        yarn encore dev --watch pour voir les changements automatiquement
        yarn encore production
             
Message Flash
-
    $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            
    #TWIG
    {# you can read and display just one flash message type... #}
    {% for message in app.flashes('notice') %}
        <div class="flash-notice">
            {{ message }}
        </div>
    {% endfor %}
    
    {# ...or you can read and display every flash message available #}
    {% for label, messages in app.flashes %}
        {% for message in messages %}
            <div class="flash-{{ label }}">
                {{ message }}
            </div>
        {% endfor %}
    {% endfor %}
    
Divers
--
        use Symfony\Component\HttpFoundation\Request;
        ...
        $request->isXmlHttpRequest(); // is it an Ajax request?
    
        $request->getPreferredLanguage(array('en', 'fr'));
    
        // retrieves GET and POST variables respectively
        $request->query->get('page');
        $request->request->get('page');
    
        // retrieves SERVER variables
        $request->server->get('HTTP_HOST');
    
        // retrieves an instance of UploadedFile identified by foo
        $request->files->get('foo');
    
        // retrieves a COOKIE value
        $request->cookies->get('PHPSESSID');
    
        // retrieves an HTTP request header, with normalized, lowercase keys
        $request->headers->get('host');
        $request->headers->get('content_type');
        
JSON
--
    public function index()
    {
        // returns '{"username":"jane.doe"}' and sets the proper Content-Type header
        return $this->json(array('username' => 'jane.doe'));
    
        // the shortcut defines three optional arguments
        // return $this->json($data, $status = 200, $headers = array(), $context = array());
    }
    
Les fichiers
--
    use Symfony\Component\HttpFoundation\File\File;
    use Symfony\Component\HttpFoundation\ResponseHeaderBag;
    
    public function download()
    {
        // load the file from the filesystem
        $file = new File('/path/to/some_file.pdf');
    
        return $this->file($file);
    
        // rename the downloaded file
        return $this->file($file, 'custom_name.pdf');
    
        // display the file contents in the browser instead of downloading it
        return $this->file('invoice_3241.pdf', 'my_invoice.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
    
PROD
--
    
    - Ne pas oublier de mettre le fichier composer.phar dans le dossier
     /usr/bin/php7.1-cli composer.phar install
     
     /usr/bin/php7.1-cli bin/console ...
     
    - Ne pas oublier de changer la version php dans 1&1 si besoin.
        Accueil->(Dans la partie Hébergement) Réglages PHP->Sélectionner le dossier et choisir la version PHP