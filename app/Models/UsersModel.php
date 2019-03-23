<?php

namespace Oquiz\Models;

use Oquiz\Utils\Database;
use PDO;

// 1 table en DB = 1 model
// 1 model = 1 classe PHP
// 1 colonne en DB  = 1 propriété
class UsersModel extends CoreModel{

    /** @var string */
    protected $first_name;
    /** @var string */
    protected $last_name;
    /** @var string */
    protected $email;
    /** @var string */
    protected $password;

    const TABLE_NAME = 'users';



    // Méthode permettant de récupérer un objet UserModel à partir d'un email
    public static function findByEmail(string $email) {
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE email = :email
        ';
        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->execute();

        return $pdoStatement->fetchObject(self::class);
    }
    /**
     * Methode pour retourner tout les quizz d'un user grâce à l'id
     * @return array
     */
    public function quizzQuestions() :array {

        return QuizzesModel::quizzByIdAuthor($this->id);
    }

    // CRUD

    // GETTERS
    public function getFirstName() :string{
        return $this->first_name;
    }

    public function getLastName() :string{
        return $this->last_name;
    }

    public function getEmail() :string{
        return $this->email;
    }

    public function getPassword() :string{
        return $this->password;
    }

    // SETTERS

    public function setFirstName(string $first_name) {
        $this->first_name = $first_name;
    }

    public function setLastName(string $last_name) {
        $this->last_name = $last_name;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

}
?>
