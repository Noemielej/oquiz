<?php

// Pour composer "Oquiz" correspond au répertoire "app"
namespace Oquiz;

// J'importe les classes qui sont dans un autre namespace
use AltoRouter; // => importe \AltoRouter

// créer la classe qui joue le rôle de FrontController : Application
class Application {
    // Je crée la propriété $router afin que le router soit dispo dans toute ma classe
    private $router;
    // Je crée la propriété $config afin que la config soit dispo dans toute ma classe (et aisni indirectement dans les views (voir CoreController))
    private $config;

    // à l'instanciation de la classe Application (dans son constructeur, donc)
    public function __construct() {
        // Récupération des données de la config
        $this->config = parse_ini_file(__DIR__ . '/config.conf');
        //dump($this->config);exit;

        // instancier le routeur
        $this->router = new AltoRouter();

        // configurer le routeur instancié
        $this->router->setBasePath($this->getConfig('BASE_PATH'));

        // Appel à la méthode s'occupant de mapper toutes les routes
        $this->defineRoutes();
    }

    // Méthode s'occupant de mapper toutes les routes
    public function defineRoutes() {
        // Home (la liste des quiz disponibles)
        $this->router->map('GET', '/', 'MainController#home', 'main_home');
        // Page d'un quiz (consulter ou jouer)
        $this->router->map('GET', '/quiz/[i:id]', 'QuizzesController#quiz', 'quizzes_quiz');
        // Page d'un quiz (consulter ou jouer)
        $this->router->map('GET', '/ajax/quiz/[i:id]', 'QuizzesController#ajaxQuiz', 'quizzes_ajaxquiz');
        // Inscription
        // $this->router->map('GET|POST', '/signup', 'UsersController#signup', 'Users_signup');
        // Connection
        $this->router->map('GET', '/signin', 'UsersController#signin', 'users_signin');
        // connexion en Ajax
        $this->router->map('POST', '/ajax/signin', 'UsersController#ajaxSigninPost', 'users_ajaxsignin');
        // Déconnection (***POST ne fonctionne pas****)
        $this->router->map('GET', '/logout', 'UsersController#logout', 'users_logout');
        // Profil user (accessible seulement à l'user connecté)
        $this->router->map('GET', '/compte', 'UsersController#compte', 'users_compte');

    }

    // créer la méthode run qui doit afficher un message (peu importe) qui permet de vérifier qu'elle est bien éxécutée
    public function run() {
        // le routeur doit faire le "match"
        // Petit AltoRouter, peux-tu stp, me donner la route correspondant à l'URL courante
        $match = $this->router->match();
        //dump($match);exit;

        // -- DISPATCH --

        // Si on trouve une route
        if ($match !== false) {
            // Je récupère les informations sur le controller et la méthode
            $dispatcherInfos = $match['target'];
            //print_r($dispatcherInfos); // debug

            // Je sépare les 2 parties se trouvant dans "target" ('MainController#home')
            $controllerAndMethod = explode('#', $dispatcherInfos);
            //print_r($controllerAndMethod); // debug

            // Je stocke les noms dans des variables
            $controllerName = $controllerAndMethod[0];
            //echo '<br>$controllerName='.$controllerName.'<br>';
            $methodName = $controllerAndMethod[1];
            //echo '$methodName='.$methodName.'<br>';

            // J'ajoute le namespace des Controllers afin d'avoir un FQCN (fully qualified class name)
            $controllerName = 'Oquiz\Controllers\\'.$controllerName;
            // résultat par exemple : BootstrapProject\Controllers\MainController

            // J'instancie le controller
            // PHP va remplacer la variable $controllerName par sa valeur
            // puis va instancier la bonne classe "new MainController()" par exemple
            // Avec les namespaces, on est obligé de spécifier le FQCN lors d'une instanciation dynamique d'une classe
            // Je passe l'objet Application courant en argument du constructeur
            $controller = new $controllerName($this);
            // J'appelle la méthode correspond à la route
            // PHP va remplacer la variable $methodName par sa valeur
            // puis va appeler la bonne méthode "->home()" par exemple
            $controller->$methodName($match['params']);
        }
        // Si aucun route ne correspond à l'URL courante
        else {
            // J'envoie une header pour spécifier le statut 404 HTTP
            \Oquiz\Controllers\CoreController::sendHttpError(404, 'Sonia - 404'); // sans utiliser de "use"
        }
    }

    // GETTERS
    // On peut spécifier le type de données retourné !!!!!
    // Si le type n'est pas le bon => Fatal Error !
    public function getRouter() : AltoRouter {
        return $this->router;
    }

    // Retourne une configuration du fichier de config
    public function getConfig(string $param) {
        // Je vérifie que la clé existe dans le tableau
        // ainsi, je suis certain de ne pas générer d'erreur de type NOTICE
        if (array_key_exists($param, $this->config)) {
            return $this->config[$param];
        }
        return false;
    }
}
