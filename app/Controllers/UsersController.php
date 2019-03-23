<?php

namespace Oquiz\Controllers;

use Oquiz\Models\UsersModel;
use Oquiz\Models\QuizzesModel;
use Oquiz\Utils\User;

class UsersController extends CoreController {

    // Methode permettant d'afficher la view (signin)
    public function signin(){

        $this->show('users/signin');
    }

    // Methode permettant de ce connecter avec ajax
    public function ajaxSigninPost() {
        // Tableau contenant toutes les erreurs
        $errorList = [];

        //dump($_POST);exit;
        // Je récupère les données
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Je traite les données si besoin
        $email = trim($email);
        $password = trim($password);

        // Je valide les données => je cherche les erreurs
        if (empty($email)) {
            $errorList[] = 'Email vide';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errorList[] = 'Email incorrect';
        }
        if (empty($password)) {
            $errorList[] = 'Mot de passe vide';
        }
        if (strlen($password) < 8) {
            $errorList[] = 'Le mot de passe doit faire au moins 8 caractères';
        }

        // Si tout est ok (aucune erreur)
        if (empty($errorList)) {
            // On va cherche le user pour l'email fourni
            $usersModel = UsersModel::findByEmail($email);
            // dump($usersModel);exit;

            // Si l'email existe
            if ($usersModel !== false) {
                // Alors, on va tester le password
                if (password_verify($password, $usersModel->getPassword())) {
                    // Je connecte l'utilisateur, peut importe comme cela est fait
                    User::connect($usersModel);

                    // Affichage d'un JSON "ok"
                    self::sendJson([
                        'code' => 1,
                        'redirect' => $this->router->generate('main_home'),
                        'errorList' => $errorList
                    ]);
                }
                else {
                    $errorList[] = 'Identifiants/mot de passe non reconnus';
                }
            }
            // Sinon
            else {
                $errorList[] = 'Email non reconnu';
            }
        }

        // Si on arrive ici, c'est que c'est pas "ok"
        self::sendJson([
            'code' => 2,
            'errorList' => $errorList
        ]);
    }
    // Methode permettant de ce deconnecter
    public function logout() {
        // Je déconnecte le user
        User::disconnect();

        // Je redirige vers la home
        $this->redirectToRoute('main_home');
    }
    // Methode permettant (si on est identifié) d'accéder à "mon compte"
    public function compte() {
        // Si l'utilisateur n'est pas connecté
        if (!User::isConnected()) {
            // Je redirige vers la page de connexion
            $this->redirect($this->router->generate('users_signin'));
        }
        // Sinon, exécute la view
        $this->show('users/compte', [
            'quizzesList' => QuizzesModel::findAll()
        ]);
    }
}


?>
