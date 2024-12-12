<?php 

class PersoAppController {

    public function index(){
        $_SESSION['page'] = 'Accueil';
        include './views/presentation.php';
    }
}