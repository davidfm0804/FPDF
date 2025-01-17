<?php
class Cranking {
    private $objranking;

    public function __construct() {
        require_once '../modelos/Mranking.php';
        $this->objranking = new Mranking();
    }

    public function cMostrarPuntuacion(){
        return $this->objranking->mMostrarPuntuacion();
    }
}
?>