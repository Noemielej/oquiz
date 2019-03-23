<?php

namespace Oquiz\Controllers;

use Oquiz\Models\QuizzesModel;
use Oquiz\Models\UsersModel;

class MainController extends CoreController {
    public function home() {

        $this->show('main/home',[
                // $quizzesList permet de données les infos sur les quiz
                'quizzesList' => QuizzesModel::findAll()
        ]);
    }
}

?>
