<?php

namespace Oquiz\Models;

use Oquiz\Utils\Database;
use PDO;

// abstract => interdiction de créer une instance de cette classe
abstract class CoreModel {

    /** @var int */
    protected $id;


    public static function find($id) {

        $sql = '
            SELECT *
            FROM '.static::TABLE_NAME.'
            WHERE id = :id
        ';
        $pdo = Database::getPDO();
        // J'utilise "prepare" !!
        $pdoStatement = $pdo->prepare($sql);
        // Je fais les bindValue
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);

        // J'exécute ma requete
        $pdoStatement->execute();

        // Je récupère le résultat sous forme d'objet
        // !Attention! Objet sous forme FQCN
        // self::class => a pour valeur le FQCN de la classe actuelle
        $result = $pdoStatement->fetchObject(static::class);

        return $result;
    }

    public static function findAll() : array {

        $sql = '
            SELECT *
            FROM '.static::TABLE_NAME.'
        ';
        $pdo = Database::getPDO();
        // J'utilise "prepare" !!
        $pdoStatement = $pdo->query($sql);

        // Je récupère le résultat sous forme d'array d'objets
        // !Attention! Objet sous forme FQCN
        // static::class => a pour valeur le FQCN de la classe actuelle
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);

        return $result;
    }

    // Méthode permettant de sauvegarder l'objet en DB
    public function save() : bool {
        // Si l'objet courant correspond à une ligne existante en DB
        if ($this->id > 0) {
            // Alors mise à jour
            return $this->update();
        }
        else {
            // Sinon, ajout (puis la propriété id récupère la nouvelle valeur)
            return $this->insert();
        }
    }

    // GETTER
    public function getId() : int {
        return $this->id;
    }

}
