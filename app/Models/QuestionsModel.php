<?php

namespace Oquiz\Models;

use Oquiz\Utils\Database;
use PDO;

// 1 table en DB = 1 model
// 1 model = 1 classe PHP
// 1 colonne en DB  = 1 propriété
class QuestionsModel extends CoreModel{

    /** @var int */
    protected $id_quiz;
    /** @var string */
    protected $question;
    /** @var string */
    protected $prop1;
    /** @var string */
    protected $prop2;
    /** @var string */
    protected $prop3;
    /** @var string */
    protected $prop4;
    /** @var int */
    protected $id_level;
    /** @var string */
    protected $anecdote;
    /** @var string */
    protected $wiki;

    const TABLE_NAME = 'questions';

    /**
     * Methode pour retourner toutes les questions grâce à l'id du quiz
     * @return array [description]
     */
    public static function questionsByIdLevel() : array {
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE id_level = :id_level
        ';
        $pdo = Database::getPDO();

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id_level', PDO::PARAM_INT);

        $pdoStatement->execute();

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);
        if ($results === false){
            return [];
        }
        return $results;
    }

    /**
     * Methode qui renvoie les réponses aux questions suivant le thème
     * @param  [type] $idQuiz
     * @return array
     */
    public function allResponceIdQuizz($idQuiz) :array{
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE id_quiz = :id_quiz
        ';
        $pdo = Database::getPDO();

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id_quiz', $idQuiz, PDO::PARAM_INT);

        $pdoStatement->execute();

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);
        if ($results === false){
            return [];
        }
        return $results;

    }
    /**
     * Methode permettant de retourner le 'level' suivant leur id
     * @return LevelsModel
     */
    public function levelsQuestions() :LevelsModel {
        return LevelsModel::find($this->id_level);
    }

    // CRUD

    // GETTERS
    public function getIdQuiz() :int {
        return $this->id_quiz;
    }

    public function getQuestion() :string {
        return $this->question;
    }

    public function getProp1() :string {
        return $this->prop1;
    }

    public function getProp2() :string {
        return $this->prop2;
    }

    public function getProp3() :string {
        return $this->prop3;
    }

    public function getProp4() :string {
        return $this->prop4;
    }

    public function getIdLevel() :int {
        return $this->id_level;
    }

    public function getAnecdote() :string {
        return $this->anecdote;
    }

    public function getWiki() :string {
        return $this->wiki;
    }

    // SETTERS
    public function setIdQuiz(int $id_quiz) {
        $this->id_quiz = $id_quiz;
    }

    public function setQuestion(string $question) {
        $this->question = $question;
    }

    public function setProp1(string $prop1) {
        $this->prop1 = $prop1;
    }

    public function setProp2(string $prop2) {
        $this->prop2 = $prop2;
    }

    public function setProp3(string $prop3) {
        $this->prop3 = $prop3;
    }

    public function setProp4(string $prop4) {
        $this->prop4 = $prop4;
    }

    public function setIdLevel(int $id_level) {
        $this->id_level = $id_level;
    }

    public function setAnecdote(string $anecdote) {
        $this->anecdote = $anecdote;
    }

    public function setWiki(string $wiki) {
        $this->wiki = $wiki;
    }

}



?>
