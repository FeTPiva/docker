<?php

namespace app\model;

use app\classes\Quarto;

Interface QuartoDAOInterface {

    public function getAllQuartos( );

    public function getQuartoByName( string $nome );

    public function getQuartoById( $idQuarto );

    public function createQuarto( Quarto $quartoInstancia );

    public function deleteQuartoById( $idQuarto );

    public function updateQuartoById( $idQuarto, Quarto $quartoInstancia );
}