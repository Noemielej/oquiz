<?php

namespace Oquiz\Controllers;

use Oquiz\Models\QuizzesModel;
use Oquiz\Models\QuestionsModel;
use Oquiz\Utils\User;

class QuizzesController extends CoreController {

    public function quiz($urlParams) {

        // Je recupère l'id qui ce trouve dans l'url
        $idQuiz = $urlParams['id'];

        // Retourne les infos du quiz (thème description)
        $quizDescript = QuizzesModel::find($idQuiz);

        // Retourne les infos sur la personne qui a créée le quiz
        $firstLastName = $quizDescript->getHost();

        // Retourne les propositions/level des questions du quiz
        $questionsQuiz =$quizDescript->quizzResponce();

        // Je créé un tableau vide, pour lui insèrer les propositions
        $mixResponce =[];
        // Je lui incorpore les 4 propositions
        for ($indexQuest=0; $indexQuest<10; $indexQuest++ ){
            $propArray = [
                $questionsQuiz[$indexQuest]->getProp1(),
                $questionsQuiz[$indexQuest]->getProp2(),
                $questionsQuiz[$indexQuest]->getProp3(),
                $questionsQuiz[$indexQuest]->getProp4()
            ];
            // et je mélange ce tableau avec les propositions
            shuffle($propArray);
            // Je push les donnnés dans le tableau "$mixResponce"
            array_push($mixResponce,$propArray);
        }
        // $dataToView => données utilisées dans la view
        $dataToView = [
            'quizz'=>$quizDescript, // ==> $quizz
            'author' => $firstLastName, // ==> $author
            'questions'=>$questionsQuiz, // ==> $questions
            'mixResponce' =>$mixResponce // ==> $mixResponce
        ];
        // Si l'user n'est pas connecté cette view s'éxecute
        if (User::isConnected()){
            $this->show('front/list-form',$dataToView);
        }
        // Sinon il accéde à cette view
        else {
            $this->show('front/quiz',$dataToView);
        }

    }

    public function ajaxQuiz(){
        dump($_GET);
        $point = 0;
        // Récupération les données du formulaire
        $choice1 = isset($_get['choice1']);
        $choice2 = isset($_get['choice2']);
        $choice3 = isset($_get['choice3']);
        $choice4 = isset($_get['choice4']);
        dump($choice1);

        // si la réponse === getProp1
        // if(isset($choice1 === $questionsQuiz[$indexQuest]->getProp1())
        //     || ($choice2 === $questionsQuiz[$indexQuest]->getProp1())
        //     || ($choice3 === $questionsQuiz[$indexQuest]->getProp1())
        //     || ($choice4 === $questionsQuiz[$indexQuest]->getProp1()) {
        //
        //     // alors true (+1point) et background color vert
        //     //return true;
        //     $point++;
        // }else {
        //   // si la réponse !== getProp1
        //   // c'est false (0point) et background color jaune
        //   return false;
        //   $point = 0
        // }



    }


}

?>
