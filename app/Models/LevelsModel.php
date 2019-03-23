<?php

namespace Oquiz\Models;

use Oquiz\Utils\Database;
use PDO;

// 1 table en DB = 1 model
// 1 model = 1 classe PHP
// 1 colonne en DB  = 1 propriété
class LevelsModel extends CoreModel{
    /** @var string */
    protected $name;
    /** @var string */
    protected $color;

    const TABLE_NAME = 'levels';


    // CRUD

    // GETTER
    public function getName() : string {
        return $this->name;
    }
    public function getColor() : string {
        return $this->color;
    }

    // SETTER
    public function setName(string $name) {
        $this->name = $name;
    }
    public function setColor(string $color) {
        $this->name = $color;
    }
}


?>
