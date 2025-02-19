<?php

class ObjectifController
{
    public function displayFormObjectif(){

       
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $code => $message) {
                ErrorHandler::addError($code, $message);
            }
            unset($_SESSION['errors']);
        }

        if (isset($_GET['id'])) {
            if (isset($_SESSION[APP_TAG]['connected'])) {

                $objectifId = $_GET['id'];
                $objectifModel = new ObjectifModel; 
                $objectifData = $objectifModel->getOneObjectif($objectifId);

                $objectifUser = new Objectif($objectifData);


            }else {
                ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=user&action=displayFormConnexion');
                exit;
            }
        }

        $objectifNameModel = new ObjectifNameModel; 
        $dataObjectif = $objectifNameModel->getAllObjectif(); 

        foreach($dataObjectif as $data){
            $objectives[] = new ObjectifName($data); 
        }

        include './views/User/objectifForm.php'; 
    }

    public function create(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $userData = [
                    'userId' => $_POST['userId'],
                    'state' => $_POST['state'],
                    'objectif' => $_POST['objectif'] ?? null,
                    'weightObjectif' => $_POST['weightObjectif'] ?? null,
                    'workoutObjectifPerWeek' => $_POST['workoutObjectifPerWeek'] ?? null
                ];

                $modelObjectif = new ObjectifModel();
                $result = $modelObjectif->create($userData);

                if ($result !== false) {
                    header('Location: index.php?ctrl=user&action=profile');
                    exit();
                }
            } catch (Exception $e) {
                ErrorHandler::addError('createObjectif', $e->getMessage());
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=objectif&action=displayFormObjectif');
                exit;
            }
        }

    }
    public function update(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $objectifId = $_POST['objectifId'];
                $userData = [
                    'userId' => $_POST['userId'],
                    'state' => $_POST['state'],
                    'objectif' => $_POST['objectif'] ?? null,
                    'weightObjectif' => $_POST['weightObjectif'] ?? null,
                    'workoutObjectifPerWeek' => $_POST['workoutObjectifPerWeek'] ?? null
                ];

                $modelObjectif = new ObjectifModel();
                $result = $modelObjectif->update($objectifId, $userData);

                if ($result !== false) {
                    header('Location: index.php?ctrl=user&action=showProfile&id='.$_SESSION[APP_TAG]['connected']['id']);
                    exit();
                }
            } catch (Exception $e) {
                ErrorHandler::addError('createObjectif', $e->getMessage());
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=objectif&action=displayFormObjectif');
                exit;
            }
        }

    }

}