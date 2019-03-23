<?php

namespace Oquiz\Models;

use Oquiz\Utils\Database;
use PDO;

// 1 table en DB = 1 model
// 1 model = 1 classe PHP
// 1 colonne en DB  = 1 propriété
class QuizzesModel extends CoreModel{

    /** @var string */
    protected $title;
    /** @var string */
    protected $description;
    /** @var int */
    protected $id_author;

    const TABLE_NAME = 'quizzes';

    /**
     * Methode permettant de trouver l'auteur du quizz
     * @param  int   $idAuthor
     * @return array
     */
    public static function findQuizByIdAuthor(int $idAuthor) : array {
        $sql = '
            SELECT users.first_name, users.last_name, quizzes.title,quizzes.description, quizzes.id_author
            FROM `users`
            INNER JOIN quizzes ON users.id = quizzes.id_author
            WHERE users.id = :idAuthor
        ';

        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':idAuthor', $idAuthor, PDO::PARAM_INT);
        $pdoStatement->execute();

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);;
    }

    /**
     *  Methode pour retourner tout les quizz d'un user grâce à l'id
     * @param  [int] $idAuthor
     * @return array
     */
    public static function quizzByIdAuthor(int $idAuthor) : array {
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE id_Author = :id_Author
        ';
        $pdo = Database::getPDO();

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id_Author', $idAuthor, PDO::PARAM_INT);

        $pdoStatement->execute();

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);
        if ($results === false){
            return [];
        }
        return $results;
    }

    /**
     * Methode permettant de retourner l'auteur du quiz grâce à son id
     * @return UsersModel
     */
    public function getHost() :UsersModel{

        return UsersModel::find($this->id_author);
    }

    /**
     * Methode pour retourner toutes les réponses suivant l'id de la question
     * @return array
     */
    public function quizzResponce() :array{

        return QuestionsModel::allResponceIdQuizz($this->id);
    }

    // CRUD

    // GETTERS
    public function getTitle() :string {
        return $this->title;
    }

    public function getDescription() :string {
        return $this->description;
    }

    public function getIdAuthor() :int {
        return $this->id_author;
    }

    // SETTERS
    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function setDescription(string $description) {
        $this->description = $description;

    }

    public function setIdAuthor(int $id_author) {
        $this->id_author = $id_author;
    }

}


?>
